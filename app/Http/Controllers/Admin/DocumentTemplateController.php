<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\DocumentTemplateRenderer;

class DocumentTemplateController extends Controller
{
    private function templateStats(): array
    {
        $allowedStatuses = ['active', 'archived'];

        return [
            'total' => DocumentTemplate::whereIn('status', $allowedStatuses)->count(),
            'active' => DocumentTemplate::where('status', 'active')->count(),
            'archived' => DocumentTemplate::where('status', 'archived')->count(),
        ];
    }

    private function templatePayload(DocumentTemplate $template): array
    {
        return [
            'id' => $template->id,
            'name' => $template->name,
            'code' => $template->code,
            'document_type' => $template->document_type,
            'category' => $template->category,
            'status' => $template->status,
            'is_default' => (bool) $template->is_default,
            'notes' => $template->notes,
            'updated_at' => optional($template->updated_at)->format('M d, Y h:i A'),
        ];
    }

    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            return redirect('/admin/login');
        }

        $allowedStatuses = [
            'active',
            'archived',
        ];

        $allowedCategories = [
            'clearance',
            'record',
            'report',
            'inventory',
        ];

        $search = trim(
            (string) $request->input(
                'search',
                ''
            )
        );

        $status = trim(
            (string) $request->input(
                'status',
                ''
            )
        );

        $category = trim(
            (string) $request->input(
                'category',
                ''
            )
        );

        $perPageInput = (int) $request->input(
            'per_page',
            10
        );

        $perPage = in_array(
            $perPageInput,
            [10, 20, 50, 100],
            true
        )
            ? $perPageInput
            : 10;


        $query = DocumentTemplate::query()
            ->whereIn(
                'status',
                $allowedStatuses
            );


        if ($search !== '') {
            $searchLower = strtolower($search);

            $query->where(
                function ($q) use ($searchLower) {
                    $q
                        ->whereRaw(
                            'LOWER(name) LIKE ?',
                            ["%{$searchLower}%"]
                        )
                        ->orWhereRaw(
                            'LOWER(code) LIKE ?',
                            ["%{$searchLower}%"]
                        )
                        ->orWhereRaw(
                            'LOWER(document_type) LIKE ?',
                            ["%{$searchLower}%"]
                        )
                        ->orWhereRaw(
                            'LOWER(category) LIKE ?',
                            ["%{$searchLower}%"]
                        )
                        ->orWhereRaw(
                            'LOWER(notes) LIKE ?',
                            ["%{$searchLower}%"]
                        );
                }
            );
        }


        if (
            $status !== '' &&
            in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {
            $query->where(
                'status',
                $status
            );
        }


        if (
            $category !== '' &&
            in_array(
                $category,
                $allowedCategories,
                true
            )
        ) {
            $query->where(
                function ($q) use ($category) {
                    $q
                        ->where(
                            'category',
                            $category
                        )
                        ->orWhere(
                            function ($fallback)
                            use ($category) {
                                $fallback
                                    ->where(
                                        function ($emptyCategory) {
                                            $emptyCategory
                                                ->whereNull('category')
                                                ->orWhere(
                                                    'category',
                                                    ''
                                                );
                                        }
                                    )
                                    ->where(
                                        'document_type',
                                        'like',
                                        "%{$category}%"
                                    );
                            }
                        );
                }
            );
        }


        $templates = $query
            ->latest()
            ->paginate(
                $perPage
            )
            ->withQueryString();


        $stats = $this->templateStats();


        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,

                'results_html' => view(
                    'admin.document-template',
                    compact(
                        'templates',
                        'stats'
                    )
                )->render(),

                'pagination' => [
                    'current_page' =>
                    $templates->currentPage(),

                    'last_page' =>
                    $templates->lastPage(),

                    'per_page' =>
                    $templates->perPage(),

                    'total' =>
                    $templates->total(),

                    'from' =>
                    $templates->firstItem()
                        ?? 0,

                    'to' =>
                    $templates->lastItem()
                        ?? 0,
                ],

                'stats' => $stats,
            ]);
        }


        return view(
            'admin.document-template',
            compact(
                'templates',
                'stats'
            )
        );
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $template = DocumentTemplate::findOrFail($id);
        $renderer = app(DocumentTemplateRenderer::class);

        return response()->json([
            'id' => $template->id,
            'name' => $template->name,
            'code' => $template->code,
            'document_type' => $template->document_type,
            'category' => $template->category,
            'engine' => $template->engine,
            'output_format' => $template->output_format,
            'content' => $renderer->renderForPreview($template),
            'paper_size' => $template->paper_size,
            'orientation' => $template->orientation,
            'status' => $template->status,
            'is_default' => (bool) $template->is_default,
            'notes' => $template->notes,
            'created_at' => optional($template->created_at)->format('M d, Y h:i A'),
            'updated_at' => optional($template->updated_at)->format('M d, Y h:i A'),
        ]);
    }

    public function archive(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            return redirect('/admin/login');
        }

        $template = DocumentTemplate::findOrFail($id);

        $template->update([
            'status' => 'archived',
            'is_default' => false,
            'updated_by' => session('admin_id'),
        ]);

        $template->refresh();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Template archived successfully.',
                'template' => $this->templatePayload($template),
                'stats' => $this->templateStats(),
            ]);
        }

        return redirect()
            ->route('admin.document-template')
            ->with('success', 'Template archived successfully.');
    }

    public function activate(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            return redirect('/admin/login');
        }

        $template = DocumentTemplate::findOrFail($id);

        $template->update([
            'status' => 'active',
            'updated_by' => session('admin_id'),
        ]);

        $template->refresh();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Template activated successfully.',
                'template' => $this->templatePayload($template),
                'stats' => $this->templateStats(),
            ]);
        }

        return redirect()
            ->route('admin.document-template')
            ->with('success', 'Template activated successfully.');
    }

    public function setDefault($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $template = DocumentTemplate::findOrFail($id);

        DB::transaction(function () use ($template) {
            DocumentTemplate::where('document_type', $template->document_type)
                ->update(['is_default' => false]);

            $template->update([
                'is_default' => true,
                'status' => 'active',
                'updated_by' => session('admin_id'),
            ]);
        });

        return redirect()
            ->route('admin.document-template')
            ->with('success', 'Default template updated successfully.');
    }
}
