<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class SupplierImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public int $created = 0;
    public int $updated = 0;

    public function model(array $row)
    {
        $existing = Supplier::where('name', $row['nama'])->first();

        $data = [
            'name'    => $row['nama'],
            'address' => $row['alamat'] ?? null,
            'phone'   => $row['telepon'] ?? null,
            'email'   => $row['email'] ?? null,
        ];

        if ($existing) {
            $existing->update($data);
            $this->updated++;
            return null;
        }

        $this->created++;
        return new Supplier($data);
    }

    public function rules(): array
    {
        return [
            'nama'  => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
        ];
    }
}