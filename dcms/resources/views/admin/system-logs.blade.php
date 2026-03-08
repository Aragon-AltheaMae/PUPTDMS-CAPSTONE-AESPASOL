<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>System Logs | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333] min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">System Logs</h1>
                <p class="text-sm text-gray-500 mt-1">
                    View recorded activities of admin, dentist, and patient users.
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#8B0000] text-white font-semibold hover:bg-[#760000] transition">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Logs Card -->
        <div class="bg-white rounded-2xl shadow border border-gray-200 overflow-hidden">

            <div class="px-6 py-4 border-b bg-[#fafafa]">
                <h2 class="text-lg font-bold text-[#8B0000] flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list"></i>
                    Audit Trail
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-[#fff7f7]">
                        <tr class="text-[#8B0000] text-xs uppercase">
                            <th>ID</th>
                            <th>Date</th>
                            <th>Role</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 text-sm">
                                <td class="font-medium">{{ $log->id }}</td>
                                <td class="text-gray-600 whitespace-nowrap">
                                    {{ $log->created_at->format('Y-m-d h:i:s A') }}
                                </td>
                                <td>
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                        @if($log->actor_role === 'admin')
                                            bg-red-100 text-red-700
                                        @elseif($log->actor_role === 'dentist')
                                            bg-blue-100 text-blue-700
                                        @elseif($log->actor_role === 'patient')
                                            bg-green-100 text-green-700
                                        @else
                                            bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst($log->actor_role) }}
                                    </span>
                                </td>
                                <td class="text-gray-700">
                                    {{ $log->actor_identifier ?? '—' }}
                                </td>
                                <td class="font-semibold text-gray-800">
                                    {{ str_replace('_', ' ', ucfirst($log->action)) }}
                                </td>
                                <td class="text-gray-700">
                                    {{ ucfirst($log->module) }}
                                </td>
                                <td class="text-gray-600 max-w-md">
                                    {{ $log->description ?? 'No description provided.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-gray-400">
                                    No system logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($logs, 'links'))
                <div class="px-6 py-4 border-t bg-[#fafafa]">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>

</body>
</html>