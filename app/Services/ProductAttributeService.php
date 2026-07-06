<?php

namespace App\Services;

use App\Repositories\Contracts\ProductAttributeRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class ProductAttributeService
{
    protected ProductAttributeRepositoryInterface $productAttributeRepository;

    public function __construct(ProductAttributeRepositoryInterface $productAttributeRepository)
    {
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function getAttributesByProduct(int $productId)
    {
        return $this->productAttributeRepository->getByProduct($productId);
    }

    public function createAttribute(int $productId, array $data)
    {
        $data['product_id'] = $productId;

        $validated = Validator::make($data, [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ])->validate();

        return $this->productAttributeRepository->create($validated);
    }

    public function updateAttribute(int $id, array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'value' => 'sometimes|required|string|max:255',
        ])->validate();

        return $this->productAttributeRepository->update($id, $validated);
    }

    public function deleteAttribute(int $id)
    {
        return $this->productAttributeRepository->delete($id);
    }
}