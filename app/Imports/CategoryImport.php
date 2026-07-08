<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public int $created = 0;
    public int $updated = 0;

    public function model(array $row)
    {
        $existing = Category::where('name', $row['nama'])->first();

        $data = [
            'name'        => $row['nama'],
            'description' => $row['deskripsi'] ?? null,
        ];

        if ($existing) {
            $existing->update($data);
            $this->updated++;
            return null;
        }

        $this->created++;
        return new Category($data);
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
        ];
    }
}