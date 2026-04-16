<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 10px;
        color: #1e293b;
        background: #ffffff;
        padding: 32px;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px solid #6366f1;
        padding-bottom: 16px;
        margin-bottom: 20px;
    }
    .brand-name {
        font-size: 22px;
        font-weight: 800;
        color: #6366f1;
        letter-spacing: -0.5px;
    }
    .brand-tagline {
        font-size: 9px;
        color: #94a3b8;
        margin-top: 2px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .report-meta {
        text-align: right;
    }
    .report-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }
    .report-period {
        font-size: 9px;
        color: #64748b;
        margin-top: 4px;
    }
    .generated-at {
        font-size: 8px;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* Summary cards */
    .summary-row {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }
    .summary-card {
        flex: 1;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
    }
    .summary-label {
        font-size: 8px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 4px;
    }
    .summary-value {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }
    .summary-value.green { color: #059669; }
    .summary-value.indigo { color: #6366f1; }

    /* Filter info */
    .filter-info {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 16px;
        font-size: 8.5px;
        color: #3b82f6;
    }
    .filter-info span { font-weight: 700; }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
    }
    thead tr {
        background: #6366f1;
        color: #ffffff;
    }
    thead th {
        padding: 8px 10px;
        text-align: left;
        font-weight: 600;
        font-size: 8.5px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    tbody tr:nth-child(even) { background: #f8fafc; }
    tbody tr:nth-child(odd)  { background: #ffffff; }
    tbody td {
        padding: 7px 10px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .badge {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 99px;
        font-size: 8px;
        font-weight: 700;
    }
    .badge-masuk  { background: #dbeafe; color: #2563eb; }
    .badge-keluar { background: #d1fae5; color: #059669; }
    .plat         { font-family: monospace; font-weight: 700; font-size: 10px; }
    .biaya        { color: #059669; font-weight: 700; }
    .muted        { color: #94a3b8; }
    .kode-qr      { font-family: monospace; font-size: 8px; color: #6366f1; }

    /* Footer */
    .footer {
        margin-top: 24px;
        padding-top: 12px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 8px;
        color: #94a3b8;
    }
    .footer-brand { color: #6366f1; font-weight: 700; }
</style>
</head>
<body>

{{-- ── Header ─────────────────────────────── --}}
<div class="header">
    <div>
        <div class="brand-name">FastTrack</div>
        <div class="brand-tagline">Parking Management System</div>
    </div>
    <div class="report-meta">
        <div class="report-title">Laporan Rekap Penghasilan</div>
        <div class="report-period">
            Periode: {{ \Carbon\Carbon::parse($dateFrom)->isoFormat('D MMMM Y') }}
            — {{ \Carbon\Carbon::parse($dateTo)->isoFormat('D MMMM Y') }}
        </div>
        <div class="generated-at">Dibuat: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</div>
    </div>
</div>

{{-- ── Summary Cards ───────────────────────── --}}
<div class="summary-row">
    <div class="summary-card">
        <div class="summary-label">Total Transaksi</div>
        <div class="summary-value indigo">{{ number_format($totalCount, 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Transaksi Selesai</div>
        <div class="summary-value">{{ number_format($totalKeluar, 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Total Pendapatan</div>
        <div class="summary-value green">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>
</div>

{{-- ── Active Filters ──────────────────────── --}}
@if($filterJenis || $filterStatus)
<div class="filter-info">
    Filter aktif:
    @if($filterJenis) <span>Jenis:</span> {{ ucfirst($filterJenis) }} &nbsp; @endif
    @if($filterStatus) <span>Status:</span> {{ ucfirst($filterStatus) }} @endif
</div>
@endif

{{-- ── Table ───────────────────────────────── --}}
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode QR</th>
            <th>Plat / Jenis</th>
            <th>Area</th>
            <th>Waktu Masuk</th>
            <th>Waktu Keluar</th>
            <th>Durasi</th>
            <th>Biaya</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksis as $i => $t)
        <tr>
            <td class="muted">{{ $i + 1 }}</td>
            <td class="kode-qr">{{ substr($t->kode_qr, 0, 16) }}…</td>
            <td>
                <span class="plat">{{ $t->kendaraan?->plat_nomor ?? '-' }}</span><br>
                <span class="muted">{{ ucfirst($t->kendaraan?->jenis_kendaraan ?? $t->tarif?->jenis_kendaraan ?? '') }}</span>
            </td>
            <td class="muted">{{ $t->areaParkir?->nama_area ?? '—' }}</td>
            <td class="muted">{{ $t->waktu_masuk->format('d/m/Y H:i') }}</td>
            <td class="muted">{{ $t->waktu_keluar?->format('d/m/Y H:i') ?? '—' }}</td>
            <td class="muted">{{ $t->durasi_jam ? $t->durasi_jam . ' jam' : '—' }}</td>
            <td>
                @if($t->biaya_total)
                    <span class="biaya">Rp {{ number_format($t->biaya_total, 0, ',', '.') }}</span>
                @else
                    <span class="muted">—</span>
                @endif
            </td>
            <td>
                <span class="badge badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align:center; padding: 24px; color: #94a3b8;">
                Tidak ada data transaksi untuk periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ── Footer ──────────────────────────────── --}}
<div class="footer">
    <div>Laporan ini digenerate otomatis oleh sistem <span class="footer-brand">FastTrack</span></div>
    <div>© {{ date('Y') }} FastTrack Parking Management</div>
</div>

</body>
</html>
