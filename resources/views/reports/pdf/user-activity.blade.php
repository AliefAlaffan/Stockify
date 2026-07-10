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
        .logo-mark-img {
            width: 50px; height: 50px; margin-right: 10px;
            vertical-align: middle;
        }
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
        .summary { width: 100%; margin: 18px 0 20px; display: table; }
        .summary-item {
            display: table-cell; width: 25%;
            background: #F6F7F3; border: 1px solid #E9EBE4;
            padding: 10px 12px;
        }
        .summary-item:first-child { border-radius: 8px 0 0 8px; border-right: none; }
        .summary-item:last-child { border-radius: 0 8px 8px 0; }
        .summary-num { font-size: 17px; font-weight: bold; color: #0D1B14; margin: 0; }
        .summary-label { font-size: 8px; text-transform: uppercase; letter-spacing: 0.6px; color: #6B7570; margin: 2px 0 0; }
        .summary-num.c-green { color: #1B6B45; }
        .summary-num.c-blue { color: #2E5C94; }
        .summary-num.c-rust { color: #B8461F; }
        .summary-num.c-amber { color: #8F6314; }

        /* ===== FEED ===== */
        .entry { width: 100%; padding: 12px 0; border-bottom: 1px solid #EFF1EB; }
        .entry-inner { display: table; width: 100%; }
        .avatar-cell { display: table-cell; width: 40px; vertical-align: top; }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            position: relative; overflow: hidden;
            box-shadow: 0 0 0 3px #ffffff;
        }
        .avatar-icon-head {
            position: absolute; top: 7px; left: 12px;
            width: 10px; height: 10px; border-radius: 50%;
        }
        .avatar-icon-body {
            position: absolute; bottom: -4px; left: 6px;
            width: 22px; height: 16px; border-radius: 11px 11px 0 0;
        }

        .avatar-created { background: #CDE8D9; }
        .avatar-created .avatar-icon-head, .avatar-created .avatar-icon-body { background: #134F33; }
        .avatar-updated { background: #D6E3F1; }
        .avatar-updated .avatar-icon-head, .avatar-updated .avatar-icon-body { background: #1E3E63; }
        .avatar-deleted { background: #F6DAD1; }
        .avatar-deleted .avatar-icon-head, .avatar-deleted .avatar-icon-body { background: #8A2E11; }
        .avatar-opname { background: #F3E2B8; }
        .avatar-opname .avatar-icon-head, .avatar-opname .avatar-icon-body { background: #8F6314; }

        .content-cell { display: table-cell; vertical-align: top; padding-left: 12px; }

        .entry-user-row { margin-bottom: 1px; }
        .role-tag {
            display: inline-block;
            font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.3px;
            color: #6B7570; background: #F6F7F3; border: 1px solid #E9EBE4;
            padding: 1px 6px; border-radius: 6px;
            margin-left: 5px;
        }

        .content-top { display: table; width: 100%; margin-bottom: 3px; }
        .content-top-left { display: table-cell; vertical-align: middle; }
        .content-top-right { display: table-cell; vertical-align: middle; text-align: right; width: 90px; }

        .entry-desc { font-size: 10.5px; color: #1F2A24; margin: 0; line-height: 1.5; }
        .entry-user { font-weight: bold; color: #0D1B14; }

        .tag { display: inline-block; font-size: 7.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.4px; padding: 2px 7px; border-radius: 8px; }
        .tag-created { background: #E7F3EC; color: #134F33; }
        .tag-updated { background: #E6EEF7; color: #1E3E63; }
        .tag-deleted { background: #FDF0EC; color: #8A2E11; }
        .tag-opname  { background: #FBF1DE; color: #8F6314; }

        .entry-time { font-size: 8px; color: #9CA39D; }

        .changes { margin-top: 6px; }
        .change-chip {
            display: inline-block;
            background: #F6F7F3;
            border: 1px solid #E9EBE4;
            border-radius: 5px;
            padding: 4px 8px;
            font-size: 8.5px;
            color: #2B372F;
            margin: 3px 5px 0 0;
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

    @php
        $totalCreated = $activities->where('action', 'created')->count();
        $totalUpdated = $activities->where('action', 'updated')->count();
        $totalDeleted = $activities->where('action', 'deleted')->count();
        $totalOpname  = $activities->where('action', 'stock_opname')->count();
    @endphp

    <div class="summary">
        <div class="summary-item">
            <p class="summary-num c-green">{{ $totalCreated }}</p>
            <p class="summary-label">Ditambahkan</p>
        </div>
        <div class="summary-item">
            <p class="summary-num c-blue">{{ $totalUpdated }}</p>
            <p class="summary-label">Diperbarui</p>
        </div>
        <div class="summary-item">
            <p class="summary-num c-rust">{{ $totalDeleted }}</p>
            <p class="summary-label">Dihapus</p>
        </div>
        <div class="summary-item">
            <p class="summary-num c-amber">{{ $totalOpname }}</p>
            <p class="summary-label">Stock Opname</p>
        </div>
    </div>

    @forelse ($activities as $activity)
        @php
            $name = $activity->user->name ?? '?';
            $initial = strtoupper(substr($name, 0, 1));
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
            $avatarClass = match($activity->action ?? 'updated') {
                'created' => 'avatar-created',
                'deleted' => 'avatar-deleted',
                'stock_opname' => 'avatar-opname',
                default => 'avatar-updated',
            };
        @endphp
        <div class="entry">
            <div class="entry-inner">
                <div class="avatar-cell">
                    <div class="avatar {{ $avatarClass }}">
                    <span class="avatar-icon-head"></span>
                    <span class="avatar-icon-body"></span>
                </div>
                </div>
                <div class="content-cell">
                    <div class="content-top">
                        <div class="content-top-left">
                            <p class="entry-desc">
                                <span class="entry-user">{{ $activity->user->name ?? 'Pengguna tidak diketahui' }}</span>
                                <br>
                                {{ $activity->description }}
                            </p>
                        </div>
                        <div class="content-top-right">
                            <span class="tag {{ $tagClass }}">{{ $tagLabel }}</span>
                        </div>
                    </div>

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

                    <p class="entry-time" style="margin-top: 6px;">{{ $activity->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">Tidak ada aktivitas pada periode ini.</div>
    @endforelse

    <div class="footer">Stockify — Sistem Manajemen Gudang</div>
</body>
</html>