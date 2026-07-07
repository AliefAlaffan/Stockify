<?php

namespace App\Http\Controllers;

use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

   public function index(Request $request)
    {
        $suppliers = $this->supplierService->getAllSuppliers($request->search);

        if ($request->ajax()) {
            return view('suppliers._table', compact('suppliers'))->render();
        }

        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $this->supplierService->createSupplier($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $this->supplierService->updateSupplier($id, $request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->supplierService->deleteSupplier($id);
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}