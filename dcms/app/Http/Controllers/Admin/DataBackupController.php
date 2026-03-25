<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataBackupController extends Controller
{
    private const ALLOCATED_BYTES = 50 * 1024 * 1024 * 1024; // 50 GB

    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        AuditLogger::log(
            'view',
            'data_backup',
            'Admin viewed the data backup page'
        );

        $query = Backup::query()->latest();

        if ($request->filled('scope') && $request->scope === 'month') {
            $query->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month);
        }

        if ($request->filled('type') && in_array($request->type, ['full', 'incremental'], true)) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && in_array($request->status, ['completed', 'failed', 'in_progress'], true)) {
            $query->where('status', $request->status);
        }

        $backups = $query->paginate(10)->withQueryString();

        $storageUsedBytes = (int) Backup::sum('size_bytes');
        $fullBackupsBytes = (int) Backup::where('type', 'full')->sum('size_bytes');
        $incrementalBackupsBytes = (int) Backup::where('type', 'incremental')->sum('size_bytes');
        $totalBackups = Backup::count();

        $thisMonthBackups = Backup::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $lastBackup = Backup::where('status', 'completed')->latest()->first();

        $autoBackupEnabled = filter_var(
            SystemSetting::getSetting('auto_backup_enabled', '1'),
            FILTER_VALIDATE_BOOLEAN
        );

        $backupSchedule = [
            'daily_enabled' => filter_var(SystemSetting::getSetting('backup_schedule_daily_enabled', '1'), FILTER_VALIDATE_BOOLEAN),
            'daily_time' => SystemSetting::getSetting('backup_schedule_daily_time', '02:00'),
            'weekly_enabled' => filter_var(SystemSetting::getSetting('backup_schedule_weekly_enabled', '1'), FILTER_VALIDATE_BOOLEAN),
            'weekly_time' => SystemSetting::getSetting('backup_schedule_weekly_time', '00:00'),
            'monthly_enabled' => filter_var(SystemSetting::getSetting('backup_schedule_monthly_enabled', '0'), FILTER_VALIDATE_BOOLEAN),
            'monthly_time' => SystemSetting::getSetting('backup_schedule_monthly_time', '23:59'),
        ];

        $totalAllocatedBytes = self::ALLOCATED_BYTES;

        return view('admin.data-backup', compact(
            'backups',
            'storageUsedBytes',
            'fullBackupsBytes',
            'incrementalBackupsBytes',
            'totalBackups',
            'thisMonthBackups',
            'lastBackup',
            'autoBackupEnabled',
            'totalAllocatedBytes',
            'backupSchedule'
        ));
    }

    public function store(Request $request): JsonResponse
    {
        if (!session('admin_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $request->validate([
            'type' => 'nullable|in:full,incremental',
        ]);

        $type = $request->input('type', 'full');

        $backupId = 'BKP-' . now()->format('Ymd-His') . '-' . strtoupper(Str::random(4));
        $filename = $backupId . '.sql.gz';
        $filePath = 'backups/' . $filename;

        $backup = Backup::create([
            'backup_id' => $backupId,
            'type' => $type,
            'size_bytes' => 0,
            'file_path' => null,
            'status' => 'in_progress',
        ]);

        $tmpSqlPath = storage_path('app/tmp_' . $backupId . '.sql');
        $tmpGzPath = $tmpSqlPath . '.gz';

        try {
            Storage::disk('local')->makeDirectory('backups');

            // Note:
            // "incremental" is currently stored as a regular DB dump as well.
            // The type is preserved for UI/history, while true incremental logic can be added later.
            $this->dumpDatabase($tmpSqlPath);
            $this->gzipFile($tmpSqlPath, $tmpGzPath);

            Storage::disk('local')->put($filePath, file_get_contents($tmpGzPath));

            $sizeBytes = Storage::disk('local')->size($filePath);

            $backup->update([
                'size_bytes' => $sizeBytes,
                'file_path' => $filePath,
                'status' => 'completed',
            ]);

            AuditLogger::log(
                'backup',
                'data_backup',
                'Admin created a ' . $type . ' backup: ' . $backupId
            );

            return response()->json([
                'success' => true,
                'message' => "Backup {$backupId} created successfully.",
                'backup' => $backup->fresh(),
            ]);
        } catch (\Throwable $e) {
            $backup->update([
                'status' => 'failed',
            ]);

            AuditLogger::log(
                'error',
                'data_backup',
                'Backup failed for ' . $backupId . ': ' . $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage(),
            ], 500);
        } finally {
            if (file_exists($tmpSqlPath)) {
                @unlink($tmpSqlPath);
            }

            if (file_exists($tmpGzPath)) {
                @unlink($tmpGzPath);
            }
        }
    }

    public function download(int $id): StreamedResponse|JsonResponse
    {
        if (!session('admin_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $backup = Backup::findOrFail($id);

        if (!$backup->file_path || !Storage::disk('local')->exists($backup->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'Backup file not found on disk.',
            ], 404);
        }

        AuditLogger::log(
            'download',
            'data_backup',
            'Admin downloaded backup: ' . $backup->backup_id
        );

        return Storage::disk('local')->download(
            $backup->file_path,
            basename($backup->file_path),
            ['Content-Type' => 'application/gzip']
        );
    }

    public function restore(int $id): JsonResponse
    {
        if (!session('admin_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $backup = Backup::findOrFail($id);

        if (!$backup->file_path || !Storage::disk('local')->exists($backup->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'Backup file not found. Cannot restore.',
            ], 404);
        }

        $gzPath = storage_path('app/restore_' . $backup->backup_id . '.sql.gz');
        $sqlPath = storage_path('app/restore_' . $backup->backup_id . '.sql');

        try {
            file_put_contents($gzPath, Storage::disk('local')->get($backup->file_path));

            $gz = gzopen($gzPath, 'rb');
            if ($gz === false) {
                throw new \RuntimeException('Unable to open compressed backup file.');
            }

            $out = fopen($sqlPath, 'wb');
            if ($out === false) {
                gzclose($gz);
                throw new \RuntimeException('Unable to create temporary SQL restore file.');
            }

            while (!gzeof($gz)) {
                fwrite($out, gzread($gz, 4096));
            }

            gzclose($gz);
            fclose($out);

            $this->importDatabase($sqlPath);

            AuditLogger::log(
                'restore',
                'data_backup',
                'Admin restored backup: ' . $backup->backup_id
            );

            return response()->json([
                'success' => true,
                'message' => "Backup {$backup->backup_id} has been restored successfully.",
            ]);
        } catch (\Throwable $e) {
            AuditLogger::log(
                'error',
                'data_backup',
                'Restore failed for ' . $backup->backup_id . ': ' . $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Restore failed: ' . $e->getMessage(),
            ], 500);
        } finally {
            if (file_exists($gzPath)) {
                @unlink($gzPath);
            }

            if (file_exists($sqlPath)) {
                @unlink($sqlPath);
            }
        }
    }

    public function destroy(int $id): JsonResponse
    {
        if (!session('admin_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $backup = Backup::findOrFail($id);
        $backupId = $backup->backup_id;

        if ($backup->file_path && Storage::disk('local')->exists($backup->file_path)) {
            Storage::disk('local')->delete($backup->file_path);
        }

        $backup->delete();

        AuditLogger::log(
            'delete',
            'data_backup',
            'Admin deleted backup: ' . $backupId
        );

        return response()->json([
            'success' => true,
            'message' => "Backup {$backupId} has been deleted.",
        ]);
    }

    public function toggleAuto(Request $request): JsonResponse
    {
        if (!session('admin_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        $enabled = $request->boolean('enabled');

        SystemSetting::setSetting('auto_backup_enabled', $enabled ? '1' : '0', 'backup');

        AuditLogger::log(
            'update',
            'data_backup',
            'Admin ' . ($enabled ? 'enabled' : 'disabled') . ' auto backup'
        );

        return response()->json([
            'success' => true,
            'enabled' => $enabled,
            'message' => 'Auto-backup has been ' . ($enabled ? 'enabled' : 'disabled') . '.',
        ]);
    }

    public function updateSchedule(Request $request): JsonResponse
    {
        if (!session('admin_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $data = $request->validate([
            'daily_enabled' => 'required|boolean',
            'daily_time' => 'required|date_format:H:i',
            'weekly_enabled' => 'required|boolean',
            'weekly_time' => 'required|date_format:H:i',
            'monthly_enabled' => 'required|boolean',
            'monthly_time' => 'required|date_format:H:i',
        ]);

        SystemSetting::setSetting('backup_schedule_daily_enabled', $data['daily_enabled'] ? '1' : '0', 'backup');
        SystemSetting::setSetting('backup_schedule_daily_time', $data['daily_time'], 'backup');

        SystemSetting::setSetting('backup_schedule_weekly_enabled', $data['weekly_enabled'] ? '1' : '0', 'backup');
        SystemSetting::setSetting('backup_schedule_weekly_time', $data['weekly_time'], 'backup');

        SystemSetting::setSetting('backup_schedule_monthly_enabled', $data['monthly_enabled'] ? '1' : '0', 'backup');
        SystemSetting::setSetting('backup_schedule_monthly_time', $data['monthly_time'], 'backup');

        $hasAnyEnabledSchedule = $data['daily_enabled'] || $data['weekly_enabled'] || $data['monthly_enabled'];
        SystemSetting::setSetting('auto_backup_enabled', $hasAnyEnabledSchedule ? '1' : '0', 'backup');

        AuditLogger::log(
            'update',
            'data_backup',
            'Admin updated backup schedule settings'
        );

        return response()->json([
            'success' => true,
            'message' => 'Backup schedule updated successfully.',
            'schedule' => $data,
            'auto_backup_enabled' => $hasAnyEnabledSchedule,
        ]);
    }

    private function dumpDatabase(string $outputPath): void
    {
        $db = config('database.default');
        $cfg = config("database.connections.{$db}");

        if (!$cfg) {
            throw new \RuntimeException('Database configuration not found.');
        }

        $driver = $cfg['driver'] ?? null;
        if (!in_array($driver, ['mysql', 'mariadb'], true)) {
            throw new \RuntimeException('Only MySQL/MariaDB backup is currently supported.');
        }

        $host = $cfg['host'] ?? '127.0.0.1';
        $port = $cfg['port'] ?? 3306;
        $name = $cfg['database'] ?? '';
        $user = $cfg['username'] ?? '';
        $pass = $cfg['password'] ?? '';

        if ($name === '' || $user === '') {
            throw new \RuntimeException('Database credentials are incomplete.');
        }

        $cnfPath = tempnam(sys_get_temp_dir(), 'mysql_');
        if ($cnfPath === false) {
            throw new \RuntimeException('Unable to create temporary MySQL config file.');
        }

        file_put_contents($cnfPath, "[client]\npassword=\"{$pass}\"\n");
        chmod($cnfPath, 0600);

        $cmd = sprintf(
            'mysqldump --defaults-extra-file=%s --host=%s --port=%s --user=%s %s > %s 2>&1',
            escapeshellarg($cnfPath),
            escapeshellarg($host),
            escapeshellarg((string) $port),
            escapeshellarg($user),
            escapeshellarg($name),
            escapeshellarg($outputPath)
        );

        exec($cmd, $output, $code);

        @unlink($cnfPath);

        if ($code !== 0) {
            throw new \RuntimeException('mysqldump failed: ' . implode("\n", $output));
        }

        if (!file_exists($outputPath) || filesize($outputPath) === 0) {
            throw new \RuntimeException('Backup dump file was not created correctly.');
        }
    }

    private function gzipFile(string $sourcePath, string $destPath): void
    {
        $in = fopen($sourcePath, 'rb');
        if ($in === false) {
            throw new \RuntimeException('Unable to open SQL dump for compression.');
        }

        $out = gzopen($destPath, 'wb9');
        if ($out === false) {
            fclose($in);
            throw new \RuntimeException('Unable to create compressed backup file.');
        }

        while (!feof($in)) {
            $chunk = fread($in, 65536);
            if ($chunk === false) {
                fclose($in);
                gzclose($out);
                throw new \RuntimeException('Error while reading SQL dump for compression.');
            }

            gzwrite($out, $chunk);
        }

        fclose($in);
        gzclose($out);
    }

    private function importDatabase(string $sqlPath): void
    {
        $db = config('database.default');
        $cfg = config("database.connections.{$db}");

        if (!$cfg) {
            throw new \RuntimeException('Database configuration not found.');
        }

        $driver = $cfg['driver'] ?? null;
        if (!in_array($driver, ['mysql', 'mariadb'], true)) {
            throw new \RuntimeException('Only MySQL/MariaDB restore is currently supported.');
        }

        $host = $cfg['host'] ?? '127.0.0.1';
        $port = $cfg['port'] ?? 3306;
        $name = $cfg['database'] ?? '';
        $user = $cfg['username'] ?? '';
        $pass = $cfg['password'] ?? '';

        if ($name === '' || $user === '') {
            throw new \RuntimeException('Database credentials are incomplete.');
        }

        $cnfPath = tempnam(sys_get_temp_dir(), 'mysql_');
        if ($cnfPath === false) {
            throw new \RuntimeException('Unable to create temporary MySQL config file.');
        }

        file_put_contents($cnfPath, "[client]\npassword=\"{$pass}\"\n");
        chmod($cnfPath, 0600);

        $cmd = sprintf(
            'mysql --defaults-extra-file=%s --host=%s --port=%s --user=%s %s < %s 2>&1',
            escapeshellarg($cnfPath),
            escapeshellarg($host),
            escapeshellarg((string) $port),
            escapeshellarg($user),
            escapeshellarg($name),
            escapeshellarg($sqlPath)
        );

        exec($cmd, $output, $code);

        @unlink($cnfPath);

        if ($code !== 0) {
            throw new \RuntimeException('mysql import failed: ' . implode("\n", $output));
        }
    }
}