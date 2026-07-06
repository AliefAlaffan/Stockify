<?php

namespace App\Services;

use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class SupplierService
{
    protected SupplierRepositoryInterface $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAllSuppliers()
    {
        return $this->supplierRepository->all();
    }

    public function getSupplierById(int $id)
    {
        return $this->supplierRepository->find($id);
    }

    public function createSupplier(array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ])->validate();

        return $this->supplierRepository->create($validated);
    }

    public function updateSupplier(int $id, array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ])->validate();

        return $this->supplierRepository->update($id, $validated);
    }

    public function deleteSupplier(int $id)
    {
        return $this->supplierRepository->delete($id);
    }
}