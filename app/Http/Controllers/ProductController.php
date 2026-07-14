<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\StockCalculatorService;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Exports\ProductTemplateExport;
use App\Imports\ProductImport;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected StockCalculatorService $stockCalculatorService;
    protected CategoryRepositoryInterface $categoryRepository;
    protected SupplierRepositoryInterface $supplierRepository;

    public function __construct(
        ProductService $productService,
        StockCalculatorService $stockCalculatorService,
        CategoryRepositoryInterface $categoryRepository,
        SupplierRepositoryInterface $supplierRepository
    ) {
        $this->productService = $productService;
        $this->stockCalculatorService = $stockCalculatorService;
        $this->categoryRepository = $categoryRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function index(Request $request)
    {
        $products = Product::with(['category', 'supplier'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('sku', 'like', "%{$request->search}%");
            })
            ->when($request->category_id, function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->when($request->supplier_id, function ($q) use ($request) {
                $q->where('supplier_id', $request->supplier_id);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $products->getCollection()->transform(function ($product) {
            $product->current_stock = $this->stockCalculatorService->getCurrentStock($product->id);
            return $product;
        });

        if ($request->ajax()) {
            return view('products._table', compact('products'))->render();
        }

        $categories = $this->categoryRepository->all();
        $suppliers = $this->supplierRepository->all();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new ProductExport($request->search),
            'produk-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProductTemplateExport(), 'template-import-produk.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new ProductImport();

        try {
            $import->import($request->file('file'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }

        $failures = $import->failures();

        if ($failures->count() > 0) {
            $errorMessages = $failures->map(function ($failure) {
                return "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            })->take(10)->toArray();

            return redirect()->route('products.index')
                ->with('import_errors', $errorMessages)
                ->with('import_summary', "{$import->created} produk ditambahkan, {$import->updated} produk diperbarui, {$failures->count()} baris gagal.");
        }

        return redirect()->route('products.index')
            ->with('success', "Import berhasil: {$import->created} produk ditambahkan, {$import->updated} produk diperbarui.");
    }

    public function create()
    {
        $categories = $this->categoryRepository->all();
        $suppliers = $this->supplierRepository->all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $this->productService->createProduct($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $product = $this->productService->getProductById($id);
        return view('products.show', compact('product'));
    }

    public function edit(int $id)
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->categoryRepository->all();
        $suppliers = $this->supplierRepository->all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $this->productService->updateProduct($id, $data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}