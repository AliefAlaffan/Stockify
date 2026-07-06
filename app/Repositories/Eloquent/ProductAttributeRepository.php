<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductAttribute;
use App\Repositories\Contracts\ProductAttributeRepositoryInterface;

class ProductAttributeRepository extends BaseRepository implements ProductAttributeRepositoryInterface
{
    public function __construct(ProductAttribute $model)
    {
        parent::__construct($model);
    }

    public function getByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)->get();
    }
}