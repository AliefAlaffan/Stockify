<?php

namespace App\Repositories\Contracts;

interface StockTransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function getByProduct(int $productId);
    public function getPendingByType(string $type);
    public function allWithRelations();
    public function findWithRelations(int $id);
    public function getStockIn(int $productId): int;
    public function getStockOut(int $productId): int;
}