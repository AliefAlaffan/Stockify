<?php

namespace App\Http\Controllers;

use App\Services\SupplierService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupplierExport;
use App\Exports\SupplierTemplateExport;
use App\Imports\SupplierImport;

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

    public function exportExcel(Request $request)
    {
        return Excel::download(new SupplierExport($request->search), 'supplier-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new SupplierTemplateExport(), 'template-import-supplier.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:xlsx,xls,csv']]);

        $import = new SupplierImport();
        $import->import($request->file('file'));

        $failures = $import->failures();
        if ($failures->count() > 0) {
            $errorMessages = $failures->map(fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))->take(10)->toArray();
            return redirect()->route('suppliers.index')
                ->with('import_errors', $errorMessages)
                ->with('import_summary', "{$import->created} supplier ditambahkan, {$import->updated} diperbarui, {$failures->count()} baris gagal.");
        }

        return redirect()->route('suppliers.index')
            ->with('success', "Import berhasil: {$import->created} supplier ditambahkan, {$import->updated} diperbarui.");
    }
}