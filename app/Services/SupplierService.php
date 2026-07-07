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

    public function getAllSuppliers(?string $search = null, int $perPage = 15)
    {
        return \App\Models\Supplier::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
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