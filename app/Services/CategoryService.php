<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function getCategoryById(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function createCategory(array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ])->validate();

        return $this->categoryRepository->create($validated);
    }

    public function updateCategory(int $id, array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ])->validate();

        return $this->categoryRepository->update($id, $validated);
    }

    public function deleteCategory(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}