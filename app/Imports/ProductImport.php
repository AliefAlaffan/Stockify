<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class ProductImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public int $created = 0;
    public int $updated = 0;

    public function model(array $row)
    {
        // Cari atau buat kategori & supplier berdasarkan nama
        $category = null;
        if (!empty($row['kategori'])) {
            $category = Category::firstOrCreate(['name' => trim($row['kategori'])]);
        }

        $supplier = null;
        if (!empty($row['supplier'])) {
            $supplier = Supplier::firstOrCreate(['name' => trim($row['supplier'])]);
        }

        // Cek apakah produk dengan SKU ini sudah ada -> update, kalau belum -> buat baru
        $existing = Product::where('sku', $row['sku'])->first();

        $data = [
            'name'            => $row['nama_produk'],
            'sku'             => $row['sku'],
            'category_id'     => $category?->id,
            'supplier_id'     => $supplier?->id,
            'description'     => $row['deskripsi'] ?? null,
            'purchase_price'  => $row['harga_beli'] ?? 0,
            'selling_price'   => $row['harga_jual'] ?? 0,
            'minimum_stock'   => $row['stok_minimum'] ?? 0,
        ];

        if ($existing) {
            $existing->update($data);
            $this->updated++;
            return null; // tidak membuat baris baru
        }

        $this->created++;
        return new Product($data);
    }

    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:255'],
            'sku'         => ['required', 'string', 'max:100'],
            'harga_beli'  => ['nullable', 'numeric', 'min:0'],
            'harga_jual'  => ['nullable', 'numeric', 'min:0'],
            'stok_minimum' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'sku.required'          => 'SKU wajib diisi.',
        ];
    }
}