<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Kendaraan <span class="g-text">Aktif</span></h1>
            <p class="text-slate-500 dark:text-white/40 text-sm">Log kendaraan yang sedang terparkir saat ini</p>
        </div>
        <div class="w-full sm:w-72">
            <input wire:model.live="search" type="search" placeholder="Cari Kode QR / Area..." class="ft-input bg-white dark:bg-[#12121e]">
        </div>
    </div>

    <div class="ft-card overflow-hidden">
        <div>
            <table class="ft-table ft-table-responsive w-full">
                <thead>
                    <tr>
                        <th>Kode Tiket</th>
                        <th>Kendaraan</th>
                        <th>Waktu Masuk</th>
                        <th>Durasi Sementara</th>
                        <th>Area Parkir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                        <tr>
                            <td data-label="Kode" class="font-mono font-bold tracking-wider text-indigo-500 text-xs max-w-[100px] truncate">{{ $t->kode_qr }}</td>
                            <td data-label="Kendaraan">
                                <p class="font-bold text-slate-900 dark:text-white capitalize">
                                    {{ ucfirst($t->tarif?->jenis_kendaraan ?? $t->kendaraan?->jenis_kendaraan ?? '—') }}
                                    @if($t->id_kendaraan && is_null($t->id_tarif))
                                        <span class="ml-1 text-[9px] bg-indigo-500/20 text-indigo-400 px-1.5 py-0.5 rounded font-black uppercase">Karyawan</span>
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500">{{ $t->id_kendaraan ? $t->kendaraan->plat_nomor : 'Manless' }}</p>
                            </td>
                            <td data-label="Waktu Masuk" class="text-sm">{{ $t->waktu_masuk->format('d M Y, H:i') }}</td>
                            <td data-label="Durasi" class="text-sm">
                                 @php
                                     $totalMinutes = (int) ceil($t->waktu_masuk->diffInSeconds(now()) / 60);
                                     $hours = floor($totalMinutes / 60);
                                     $minutes = $totalMinutes % 60;
                                 @endphp
                                 <span class="badge-masuk">
                                     {{ $hours > 0 ? $hours . ' jam ' : '' }}{{ $minutes }} menit
                                 </span>
                             </td>
                            <td data-label="Area">{{ $t->areaParkir?->nama_area ?? 'N/A' }}</td>
                            <td data-label="Status" class="mobile-hidden">
                                <span class="badge-aktif">PARKIR</span>
                            </td>
                            <td data-label="Aksi">
                                @php
                                    $jenisLabel = ucfirst($t->tarif?->jenis_kendaraan ?? $t->kendaraan?->jenis_kendaraan ?? '—');
                                @endphp
                                <button onclick="cetakKarcisUlang('{{ $t->kode_qr }}', '{{ $t->waktu_masuk->format('d M Y - H:i') }}', '{{ $jenisLabel }}', '{{ $t->areaParkir?->nama_area }}')" class="btn-primary py-1.5 px-3 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-white/10 dark:text-white dark:hover:bg-white/20">Cetak Karcis</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-500">Belum ada kendaraan yang terparkir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transaksis->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-white/5">
                {{ $transaksis->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>

    <script>
    function cetakKarcisUlang(qr, masuk, jenis, area) {
        var printWindow = window.open('', '', 'width=340,height=500');
        var html = '<html><head><title>Cetak Tiket</title>';
        html += '\x3Cstyle\x3E';
        html += 'body { font-family: "Courier New", Courier, monospace; text-align: center; margin: 0; padding: 20px; color: #000; }';
        html += 'h2 { margin: 0 0 10px 0; font-size: 20px; border-bottom: 1px dashed #000; padding-bottom: 10px; }';
        html += '.qrc-container { display: flex; justify-content: center; margin: 15px 0; }';
        html += '.fw-bold { font-weight: bold; font-size: 16px; margin: 5px 0 15px 0; letter-spacing: 1px; }';
        html += 'p { margin: 4px 0; font-size: 13px; }';
        html += '.det { text-align: left; max-width: 200px; margin: 0 auto; border-top: 1px dashed #000; padding-top: 10px; }';
        html += '.det p { display: flex; justify-content: space-between; }';
        html += '.note { margin-top: 15px; font-size: 11px; border-top: 1px dashed #000; padding-top: 10px; }';
        html += '\x3C/style\x3E';
        html += '\x3Cscript src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"\x3E\x3C/script\x3E';
        html += '\x3C/head\x3E\x3Cbody\x3E';
        html += '\x3Ch2\x3EFastTrack Parking\x3C/h2\x3E';
        html += '\x3Cdiv class="qrc-container"\x3E\x3Cdiv id="qrc" style="width:160px;"\x3E\x3C/div\x3E\x3C/div\x3E';
        html += '\x3Cp class="fw-bold"\x3E' + qr + '\x3C/p\x3E';
        html += '\x3Cdiv class="det"\x3E';
        html += '\x3Cp\x3E\x3Cspan\x3EJenis:\x3C/span\x3E \x3Cstrong\x3E' + jenis + '\x3C/strong\x3E\x3C/p\x3E';
        html += '\x3Cp\x3E\x3Cspan\x3EArea:\x3C/span\x3E \x3Cstrong\x3E' + area + '\x3C/strong\x3E\x3C/p\x3E';
        html += '\x3Cp\x3E\x3Cspan\x3EMasuk:\x3C/span\x3E \x3Cstrong\x3E' + masuk + '\x3C/strong\x3E\x3C/p\x3E';
        html += '\x3C/div\x3E';
        html += '\x3Cp class="note"\x3ESimpan tiket untuk keluar.\x3C/p\x3E';
        html += '\x3Cscript\x3E';
        html += 'window.onload = function() {';
        html += '  new QRCode(document.getElementById("qrc"), { text: "' + qr + '", width: 160, height: 160 });';
        html += '  setTimeout(function() { window.print(); window.close(); }, 800);';
        html += '};';
        html += '\x3C/script\x3E';
        html += '\x3C/body\x3E\x3C/html\x3E';
        
        printWindow.document.write(html);
        printWindow.document.close();
    }
    </script>
</div>
