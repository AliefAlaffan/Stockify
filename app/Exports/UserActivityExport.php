<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserActivityExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $activities;

    public function __construct($activities)
    {
        $this->activities = $activities;
    }

    public function collection()
    {
        return $this->activities;
    }

    public function headings(): array
    {
        return ['Waktu Dicatat', 'Pengguna', 'Jenis', 'Produk', 'Jumlah', 'Tanggal Transaksi', 'Status'];
    }

    public function map($activity): array
    {
        return [
            $activity->created_at->format('d M Y H:i'),
            $activity->user->name ?? '-',
            $activity->type,
            $activity->product->name ?? '-',
            $activity->quantity,
            \Carbon\Carbon::parse($activity->date)->format('d M Y'),
            $activity->status,
        ];
    }
}