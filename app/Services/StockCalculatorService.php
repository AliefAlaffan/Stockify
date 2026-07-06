<?php

namespace App\Services;

use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;

class StockCalculatorService
{
    protected StockTransactionRepositoryInterface $stockTransactionRepository;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        StockTransactionRepositoryInterface $stockTransactionRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->stockTransactionRepository = $stockTransactionRepository;
        $this->productRepository = $productRepository;
    }

    public function getCurrentStock(int $productId): int
    {
        $stockIn = $this->stockTransactionRepository->getStockIn($productId);
        $stockOut = $this->stockTransactionRepository->getStockOut($productId);

        return $stockIn - $stockOut;
    }

    public function getAllProductsWithStock()
    {
        $products = $this->productRepository->all();

        return $products->map(function ($product) {
            $product->current_stock = $this->getCurrentStock($product->id);
            return $product;
        });
    }

    public function getLowStockProducts()
    {
        return $this->getAllProductsWithStock()
            ->filter(fn($product) => $product->current_stock <= $product->minimum_stock)
            ->values();
    }
}