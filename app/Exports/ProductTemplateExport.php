<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        return [
            ['Contoh Produk', 'SKU-001', 'Elektronik', 'PT Sumber Jaya', 'Deskripsi singkat produk', 50000, 75000, 10],
        ];
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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}