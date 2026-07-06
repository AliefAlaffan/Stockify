<?php

namespace App\Repositories\Contracts;

interface ProductAttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function getByProduct(int $productId);
}