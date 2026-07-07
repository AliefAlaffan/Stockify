<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1a1a1a; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        p.subtitle { color: #666; margin-top: 0; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th { background: #f3f4f6; text-align: left; padding: 6px 8px; font-size: 10px; text-transform: uppercase; }
        td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .summary { display: table; width: 100%; margin-bottom: 16px; }
        .summary-item { display: table-cell; width: 25%; padding: 8px; }
        .summary-label { font-size: 9px; text-transform: uppercase; color: #888; }
        .summary-value { font-size: 14px; font-weight: bold; }
        .tag-low { color: #b91c1c; font-weight: bold; }
        .tag-safe { color: #15803d; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Stok Barang</h1>
    <p class="subtitle">Dicetak pada {{ now()->format('d M Y H:i') }}</p>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-label">Total Produk</div>
            <div class="summary-value">{{ $summary['total_products'] }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Unit</div>
            <div class="summary-value">{{ number_format($summary['total_units']) }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Nilai Stok</div>
            <div class="summary-value">Rp {{ number_format($summary['total_value'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Stok Menipis</div>
            <div class="summary-value">{{ $summary['low_stock_count'] }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>SKU</th>
                <th>Kategori</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Stok Akhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>+{{ $product->period_in }}</td>
                    <td>-{{ $product->period_out }}</td>
                    <td>{{ $product->current_stock }}</td>
                    <td class="{{ $product->current_stock <= $product->minimum_stock ? 'tag-low' : 'tag-safe' }}">
                        {{ $product->current_stock <= $product->minimum_stock ? 'Menipis' : 'Aman' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>