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
        .logo-mark-img { width: 50px; height: 50px; margin-right: 10px; vertical-align: middle; }
        .brand-row { display: table; }
        .brand-cell { display: table-cell; vertical-align: middle; }
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
        .summary-num.c-green { color: #134F33; }
        .summary-num.c-blue { color: #1E3E63; }
        .summary-num.c-rust { color: #8A2E11; }
        .summary-num.c-amber { color: #8F6314; }

        /* ===== TABLE ===== */
        table.data { width: 100%; border-collapse: collapse; }
        table.data thead th {
            background: #0D1B14; color: #ffffff;
            text-align: left; padding: 9px 12px; font-size: 8.5px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        table.data thead th:first-child { border-radius: 6px 0 0 6px; }
        table.data thead th:last-child { border-radius: 0 6px 6px 0; }
        table.data tbody td { padding: 9px 12px; border-bottom: 1px solid #EFF1EB; font-size: 10px; vertical-align: top; }
        table.data tbody tr:nth-child(even) { background: #FAFBF8; }

        .cell-time { color: #6B7570; font-size: 8.5px; white-space: nowrap; }

        .cell-user { font-weight: bold; color: #0D1B14; }
        .role-tag {
            display: inline-block;
            font-size: 6.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.3px;
            color: #6B7570; background: #F6F7F3; border: 1px solid #E9EBE4;
            padding: 1px 6px; border-radius: 6px;
            margin-left: 4px;
        }

        .tag { display: inline-block; font-size: 7.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.4px; padding: 2px 8px; border-radius: 10px; white-space: nowrap; }
        .tag-created { background: #E7F3EC; color: #134F33; }
        .tag-updated { background: #E6EEF7; color: #1E3E63; }
        .tag-deleted { background: #FDF0EC; color: #8A2E11; }
        .tag-opname  { background: #FBF1DE; color: #8F6314; }

        .cell-desc { font-size: 10px; color: #1F2A24; line-height: 1.5; }

        .changes { margin-top: 5px; }
        .change-chip {
            display: inline-block;
            background: #F6F7F3; border: 1px solid #E9EBE4; border-radius: 5px;
            padding: 3px 7px; font-size: 8px; color: #2B372F;
            margin: 2px 4px 0 0;
        }
        .change-chip b { color: #0D1B14; }
        .change-arrow { color: #9CA39D; margin: 0 3px; }

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
                        <h1>Aktivitas Pengguna</h1>
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

    @if ($activities->count() > 0)
        <table class="data">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Pengguna</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    @php
                        $tagClass = match($activity->action ?? 'updated') {
                            'created' => 'tag-created',
                            'deleted' => 'tag-deleted',
                            'stock_opname' => 'tag-opname',
                            default => 'tag-updated',
                        };
                        $tagLabel = match($activity->action ?? 'updated') {
                            'created' => 'Ditambahkan',
                            'deleted' => 'Dihapus',
                            'stock_opname' => 'Stock Opname',
                            default => 'Diperbarui',
                        };
                    @endphp
                    <tr>
                        <td class="cell-time">{{ $activity->created_at->format('d M Y') }}<br>{{ $activity->created_at->format('H:i') }}</td>
                        <td>
                            <span class="cell-user">{{ $activity->user->name ?? 'Pengguna tidak diketahui' }}</span>
                            @if ($activity->user->role ?? null)
                                <span class="role-tag">{{ $activity->user->role }}</span>
                            @endif
                        </td>
                        <td><span class="tag {{ $tagClass }}">{{ $tagLabel }}</span></td>
                        <td>
                            <p class="cell-desc">{{ $activity->description }}</p>
                            @if (!empty($activity->changes) && is_array($activity->changes))
                                <div class="changes">
                                    @foreach ($activity->changes as $field => $change)
                                        @if (is_array($change) && array_key_exists('from', $change))
                                            <span class="change-chip">
                                                <b>{{ ucwords(str_replace('_', ' ', $field)) }}:</b>
                                                {{ Str::limit(trim((string) ($change['from'] ?? '')) ?: 'kosong', 22) }}
                                                <span class="change-arrow">&#8594;</span>
                                                {{ Str::limit(trim((string) ($change['to'] ?? '')) ?: 'kosong', 22) }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">Tidak ada aktivitas pada periode ini.</div>
    @endif

    <div class="footer">Stockify — Sistem Manajemen Gudang</div>
</body>
</html>