<?php

namespace App\Http\Controllers;

use App\Services\ProductAttributeService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    protected ProductAttributeService $productAttributeService;
    protected ProductService $productService;

    public function __construct(
        ProductAttributeService $productAttributeService,
        ProductService $productService
    ) {
        $this->productAttributeService = $productAttributeService;
        $this->productService = $productService;
    }

    public function index(int $productId)
    {
        $product = $this->productService->getProductById($productId);
        $attributes = $this->productAttributeService->getAttributesByProduct($productId);
        return view('product-attributes.index', compact('product', 'attributes'));
    }

    public function store(Request $request, int $productId)
    {
        $this->productAttributeService->createAttribute($productId, $request->all());
        return redirect()->route('products.attributes.index', $productId)
            ->with('success', 'Atribut berhasil ditambahkan.');
    }

    public function update(Request $request, int $productId, int $id)
    {
        $this->productAttributeService->updateAttribute($id, $request->all());
        return redirect()->route('products.attributes.index', $productId)
            ->with('success', 'Atribut berhasil diperbarui.');
    }

    public function destroy(int $productId, int $id)
    {
        $this->productAttributeService->deleteAttribute($id);
        return redirect()->route('products.attributes.index', $productId)
            ->with('success', 'Atribut berhasil dihapus.');
    }
}