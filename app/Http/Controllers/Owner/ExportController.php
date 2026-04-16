<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Shared query builder respecting active filters.
     */
    private function buildQuery(Request $request)
    {
        $dateFrom     = $request->input('dateFrom', now()->startOfMonth()->format('Y-m-d'));
        $dateTo       = $request->input('dateTo', now()->format('Y-m-d'));
        $filterJenis  = $request->input('filterJenis', '');
        $filterStatus = $request->input('filterStatus', '');

        return Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->when($dateFrom,     fn($q) => $q->whereDate('waktu_masuk', '>=', $dateFrom))
            ->when($dateTo,       fn($q) => $q->whereDate('waktu_masuk', '<=', $dateTo))
            ->when($filterStatus, fn($q) => $q->where('status', $filterStatus))
            ->when($filterJenis,  fn($q) => $q->whereHas('kendaraan', fn($k) => $k->where('jenis_kendaraan', $filterJenis)))
            ->latest('waktu_masuk');
    }

    /**
     * Export rekap transaksi as CSV.
     */
    public function csv(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $transaksis = $this->buildQuery($request)->get();

        $dateFrom = $request->input('dateFrom', now()->startOfMonth()->format('Y-m-d'));
        $dateTo   = $request->input('dateTo', now()->format('Y-m-d'));
        $filename = 'fasttrack-rekap-' . $dateFrom . '_sd_' . $dateTo . '.csv';

        return response()->streamDownload(function () use ($transaksis) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM agar Excel tidak salah baca karakter Indonesia
            fwrite($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, [
                'No',
                'Kode QR',
                'Plat Nomor',
                'Jenis Kendaraan',
                'Area Parkir',
                'Waktu Masuk',
                'Waktu Keluar',
                'Durasi (Jam)',
                'Biaya (Rp)',
                'Status',
            ]);

            foreach ($transaksis as $i => $t) {
                fputcsv($handle, [
                    $i + 1,
                    $t->kode_qr,
                    $t->kendaraan?->plat_nomor ?? '-',
                    ucfirst($t->kendaraan?->jenis_kendaraan ?? $t->tarif?->jenis_kendaraan ?? ''),
                    $t->areaParkir?->nama_area ?? '',
                    $t->waktu_masuk->format('Y-m-d H:i:s'),
                    $t->waktu_keluar?->format('Y-m-d H:i:s') ?? '',
                    $t->durasi_jam ?? '',
                    $t->biaya_total ?? '',
                    ucfirst($t->status),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export rekap transaksi as PDF.
     */
    public function pdf(Request $request): Response
    {
        $dateFrom     = $request->input('dateFrom', now()->startOfMonth()->format('Y-m-d'));
        $dateTo       = $request->input('dateTo', now()->format('Y-m-d'));
        $filterJenis  = $request->input('filterJenis', '');
        $filterStatus = $request->input('filterStatus', '');

        $transaksis  = $this->buildQuery($request)->get();
        $totalCount  = $transaksis->count();
        $totalKeluar = $transaksis->where('status', 'keluar')->count();
        $totalRevenue = $transaksis->where('status', 'keluar')->sum('biaya_total');

        $pdf = Pdf::loadView('exports.rekap-pdf', compact(
            'transaksis',
            'dateFrom',
            'dateTo',
            'filterJenis',
            'filterStatus',
            'totalCount',
            'totalKeluar',
            'totalRevenue',
        ))
        ->setPaper('A4', 'landscape')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', false)
        ->setOption('defaultFont', 'DejaVu Sans');

        $filename = 'fasttrack-rekap-' . $dateFrom . '_sd_' . $dateTo . '.pdf';

        return $pdf->download($filename);
    }
}
