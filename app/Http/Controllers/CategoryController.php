<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

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
}