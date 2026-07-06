<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected CategoryRepositoryInterface $categoryRepository;
    protected SupplierRepositoryInterface $supplierRepository;

    public function __construct(
        ProductService $productService,
        CategoryRepositoryInterface $categoryRepository,
        SupplierRepositoryInterface $supplierRepository
    ) {
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('products.index', compact('products'));
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