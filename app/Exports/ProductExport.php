<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;

    public function __construct(?string $search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return Product::with(['category', 'supplier'])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'SKU',
            'Kategori',
            'Supplier',
            'Deskripsi',
            'Harga Beli',
            'Harga Jual',
            'Stok Minimum',
        ];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->sku,
            $product->category->name ?? '',
            $product->supplier->name ?? '',
            $product->description ?? '',
            $product->purchase_price,
            $product->selling_price,
            $product->minimum_stock,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}