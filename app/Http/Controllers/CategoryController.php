<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryExport;
use App\Exports\CategoryTemplateExport;
use App\Imports\CategoryImport;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllCategories($request->search);

        if ($request->ajax()) {
            return view('categories._table', compact('categories'))->render();
        }

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->categoryService->createCategory($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $this->categoryService->updateCategory($id, $request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->categoryService->deleteCategory($id);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new CategoryExport($request->search), 'kategori-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new CategoryTemplateExport(), 'template-import-kategori.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:xlsx,xls,csv']]);

        $import = new CategoryImport();
        $import->import($request->file('file'));

        $failures = $import->failures();
        if ($failures->count() > 0) {
            $errorMessages = $failures->map(fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))->take(10)->toArray();
            return redirect()->route('categories.index')
                ->with('import_errors', $errorMessages)
                ->with('import_summary', "{$import->created} kategori ditambahkan, {$import->updated} diperbarui, {$failures->count()} baris gagal.");
        }

        return redirect()->route('categories.index')
            ->with('success', "Import berhasil: {$import->created} kategori ditambahkan, {$import->updated} diperbarui.");
    }
}