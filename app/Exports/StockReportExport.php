<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StockReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return ['Produk', 'SKU', 'Kategori', 'Masuk (Periode)', 'Keluar (Periode)', 'Stok Akhir', 'Status'];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->sku,
            $product->category->name ?? '-',
            $product->period_in,
            $product->period_out,
            $product->current_stock,
            $product->current_stock <= $product->minimum_stock ? 'Menipis' : 'Aman',
        ];
    }
}