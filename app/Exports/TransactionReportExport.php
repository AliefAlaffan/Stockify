<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jenis', 'Produk', 'Jumlah', 'Dicatat Oleh', 'Status', 'Catatan'];
    }

    public function map($trx): array
    {
        return [
            \Carbon\Carbon::parse($trx->date)->format('d M Y'),
            $trx->type,
            $trx->product->name ?? '-',
            $trx->quantity,
            $trx->user->name ?? '-',
            $trx->status,
            $trx->notes ?? '-',
        ];
    }
}