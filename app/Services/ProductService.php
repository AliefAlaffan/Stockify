<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->allWithRelations();
    }

    public function getProductById(int $id)
    {
        return $this->productRepository->findWithRelations($id);
    }

    public function createProduct(array $data)
    {
        $validated = Validator::make($data, [
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'minimum_stock' => 'required|integer|min:0',
        ])->validate();

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $validated['image'] = $data['image']->store('products', 'public');
        }

        return $this->productRepository->create($validated);
    }

    public function updateProduct(int $id, array $data)
    {
        $validated = Validator::make($data, [
            'category_id' => 'sometimes|required|exists:categories,id',
            'supplier_id' => 'sometimes|required|exists:suppliers,id',
            'name' => 'sometimes|required|string|max:255',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $id,
            'description' => 'nullable|string',
            'purchase_price' => 'sometimes|required|numeric|min:0',
            'selling_price' => 'sometimes|required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'minimum_stock' => 'sometimes|required|integer|min:0',
        ])->validate();

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $product = $this->productRepository->find($id);
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $data['image']->store('products', 'public');
        }

        return $this->productRepository->update($id, $validated);
    }

    public function deleteProduct(int $id)
    {
        $product = $this->productRepository->find($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        return $this->productRepository->delete($id);
    }
}