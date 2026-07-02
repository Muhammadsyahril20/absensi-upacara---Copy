<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absen - {{ $event->nama_kegiatan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Khusus agar rapi saat dicetak ke PDF */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; }
            .print-border { border: 1px solid #000; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen font-sans p-6">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6 no-print">
            <a href="{{ route('admin.events') }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
            
            <div class="flex space-x-3">
                <a href="{{ route('admin.export.excel', $event->id) }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded-lg shadow flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel
                </a>
                
                <button onclick="window.print()" class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold py-2 px-4 rounded-lg shadow flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                    Cetak PDF
                </button>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 print-border">
            
            <div class="text-center mb-8 border-b pb-6">
                <h1 class="text-2xl font-black text-blue-900 uppercase tracking-wide">Laporan Kehadiran Peserta</h1>
                <h2 class="text-lg font-bold text-slate-700 mt-1">{{ $event->nama_kegiatan }}</h2>
                <p class="text-slate-500 text-sm mt-1">Tanggal: {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100 text-slate-600 text-sm uppercase tracking-wider">
                            <th class="p-4 border-b-2 border-slate-200 font-bold w-12 text-center">No</th>
                            <th class="p-4 border-b-2 border-slate-200 font-bold">Nama Lengkap</th>
                            <th class="p-4 border-b-2 border-slate-200 font-bold">NIP</th>
                            <th class="p-4 border-b-2 border-slate-200 font-bold">Instansi/Bagian</th>
                            <th class="p-4 border-b-2 border-slate-200 font-bold">Waktu Absen</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-700 text-sm">
                        @forelse($event->attendances as $index => $absen)
                            <tr class="hover:bg-slate-50 border-b border-slate-100">
                                <td class="p-4 text-center">{{ $index + 1 }}</td>
                                <td class="p-4 font-semibold">{{ $absen->nama }}</td>
                                <td class="p-4">{{ $absen->nip }}</td>
                                <td class="p-4">{{ $absen->instansi }}</td>
                                <td class="p-4 text-slate-500">{{ $absen->created_at->format('H:i:s') }} WIB</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500 italic">Belum ada peserta yang melakukan absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-8 text-right text-sm text-slate-500 no-print">
                Total Hadir: <span class="font-bold text-blue-700">{{ $event->attendances->count() }} Peserta</span>
            </div>
        </div>
    </div>

</body>
</html>