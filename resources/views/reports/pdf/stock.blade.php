<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 32px 36px; }
        * { box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1F2A24; }

        /* ===== HEADER ===== */
        .header { width: 100%; margin-bottom: 22px; }
        .header-inner { display: table; width: 100%; }
        .header-left { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }
        .brand-row { display: table; }
        .brand-cell { display: table-cell; vertical-align: middle; }
        .logo-mark-img { width: 30px; height: 30px; margin-right: 10px; vertical-align: middle; }
        .brand { font-size: 8.5px; letter-spacing: 2px; text-transform: uppercase; color: #6B7570; margin: 0 0 3px; }
        h1 { font-size: 20px; font-weight: bold; color: #0D1B14; margin: 0; }
        .printed-at { font-size: 9px; color: #6B7570; margin: 0 0 2px; }
        .range-badge {
            display: inline-block; background: #E7F3EC; color: #134F33;
            font-size: 8.5px; font-weight: bold; padding: 3px 9px; border-radius: 10px;
        }
        .header-divider { width: 100%; height: 3px; background: #1B6B45; margin-top: 16px; border-radius: 2px; }

        /* ===== SUMMARY BAR ===== */
        .summary { width: 100%; margin: 0 0 20px; display: table; border-spacing: 8px 0; }
        .summary-item {
            display: table-cell; width: 25%;
            background: #F6F7F3; border: 1px solid #E9EBE4; border-radius: 8px;
            padding: 10px 12px;
        }
        .summary-num { font-size: 17px; font-weight: bold; color: #0D1B14; margin: 0; }
        .summary-label { font-size: 8px; text-transform: uppercase; letter-spacing: 0.6px; color: #6B7570; margin: 2px 0 0; }
        .summary-item.alert { background: #FDF0EC; border-color: #F2CCBE; }
        .summary-item.alert .summary-num { color: #B8461F; }

        /* ===== TABLE ===== */
        table.data { width: 100%; border-collapse: collapse; }
        table.data thead th {
            background: #0D1B14; color: #ffffff;
            text-align: left; padding: 9px 12px; font-size: 8.5px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        table.data thead th:first-child { border-radius: 6px 0 0 6px; }
        table.data thead th:last-child { border-radius: 0 6px 6px 0; }
        table.data tbody td { padding: 8px 12px; border-bottom: 1px solid #EFF1EB; font-size: 10px; vertical-align: middle; }
        table.data tbody tr:nth-child(even) { background: #FAFBF8; }

        .sku { color: #9CA39D; font-size: 8px; }
        .qty-in { color: #1B6B45; font-weight: bold; }
        .qty-out { color: #B8461F; font-weight: bold; }
        .stock-final { font-weight: bold; color: #0D1B14; font-size: 11px; }

        .badge { display: inline-block; padding: 2px 9px; border-radius: 10px; font-size: 8.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.3px; }
        .badge-low { background: #FDF0EC; color: #B8461F; }
        .badge-safe { background: #E7F3EC; color: #134F33; }

        .footer { position: fixed; bottom: -20px; left: 0; right: 0; text-align: center; font-size: 8px; color: #9CA39D; border-top: 1px solid #EFF1EB; padding-top: 6px; }

        .empty-state { text-align: center; padding: 50px 0; color: #9CA39D; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-inner">
            <div class="header-left">
                <div class="brand-row">
                    <div class="brand-cell"><img src="{{ public_path('images/stockify-icon-256.png') }}" class="logo-mark-img"></div>
                    <div class="brand-cell">
                        <p class="brand">Stockify — Laporan Gudang</p>
                        <h1>Laporan Stok Barang</h1>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <p class="printed-at">Dicetak {{ now()->format('d M Y, H:i') }}</p>
                @if (($startDate ?? null) && ($endDate ?? null))
                    <span class="range-badge">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} &ndash; {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
                @endif
            </div>
        </div>
        <div class="header-divider"></div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <p class="summary-num">{{ $summary['total_products'] }}</p>
            <p class="summary-label">Total Produk</p>
        </div>
        <div class="summary-item">
            <p class="summary-num">{{ number_format($summary['total_units']) }}</p>
            <p class="summary-label">Total Unit</p>
        </div>
        <div class="summary-item">
            <p class="summary-num">Rp {{ number_format($summary['total_value'], 0, ',', '.') }}</p>
            <p class="summary-label">Nilai Stok</p>
        </div>
        <div class="summary-item alert">
            <p class="summary-num">{{ $summary['low_stock_count'] }}</p>
            <p class="summary-label">Stok Menipis</p>
        </div>
    </div>

    @if ($products->count() > 0)
        <table class="data">
            <thead>
                <tr>
                    <th>Produk</th>
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
                        <td>
                            {{ $product->name }}<br>
                            <span class="sku">{{ $product->sku }}</span>
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td class="qty-in">+{{ $product->period_in }}</td>
                        <td class="qty-out">-{{ $product->period_out }}</td>
                        <td class="stock-final">{{ $product->current_stock }}</td>
                        <td>
                            @if ($product->current_stock <= $product->minimum_stock)
                                <span class="badge badge-low">Menipis</span>
                            @else
                                <span class="badge badge-safe">Aman</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">Tidak ada data produk untuk periode ini.</div>
    @endif

    <div class="footer">Stockify — Sistem Manajemen Gudang</div>
</body>
</html>