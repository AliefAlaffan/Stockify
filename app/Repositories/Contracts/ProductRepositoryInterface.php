<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function findBySku(string $sku);
    public function lowStock();
    public function allWithRelations();
    public function findWithRelations(int $id);
}