<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories(?string $search = null, int $perPage = 15)
    {
        return Category::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function deleteCategory(int $id): void
    {
        Category::findOrFail($id)->delete();
    }
}