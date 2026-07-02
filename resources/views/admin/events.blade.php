<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Absensi Pelindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen font-sans">

    <nav class="bg-white border-b-[4px] border-blue-700 px-6 py-3 flex justify-between items-center shadow-sm">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('img/logo-pelindo.png') }}" alt="Logo Pelindo" class="h-10 w-auto object-contain">
            
            <span class="text-xl font-bold text-slate-700 tracking-wide border-l-2 border-slate-200 pl-4">
                Attendance System
            </span>
        </div>
        <div class="text-blue-700 font-semibold bg-blue-50 px-4 py-1.5 rounded-full text-sm border border-blue-200">
            Humas Division
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
        
        <div class="lg:col-span-1">
    <div class="sticky top-6 space-y-6">
        
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <h2 class="text-lg font-bold text-slate-800 uppercase tracking-wide">Buat Upacara</h2>
            </div>
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-5 text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-slate-500 text-xs font-bold mb-2 uppercase tracking-wider">Pilih Banner Upacara</label>
                    <input type="file" name="banner" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                </div>

                <div>
                    <label class="block text-slate-500 text-xs font-bold mb-2 uppercase tracking-wider">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" placeholder="Contoh: Upacara Hari Pahlawan" class="w-full bg-slate-50 text-slate-800 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                </div>

                <div>
                    <label class="block text-slate-500 text-xs font-bold mb-2 uppercase tracking-wider">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal" class="w-full bg-slate-50 text-slate-800 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                </div>

                <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all uppercase tracking-wider text-sm flex justify-center items-center">
                    Simpan & Generate QR
                </button>
            </form>
        </div>

        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <h2 class="text-lg font-bold text-slate-800 uppercase tracking-wide">Kelola Instansi</h2>
            </div>

            @if(session('success_instansi'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-5 text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success_instansi') }}
                </div>
            @endif

            <form action="{{ route('instansi.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="text" name="nama_instansi" placeholder="Contoh: Magang/PKL" class="w-full bg-slate-50 text-slate-800 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all text-sm" required>
                </div>
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-4 rounded-lg shadow transition-all uppercase tracking-wider text-xs">
                    Tambah List Instansi
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Daftar Instansi Saat Ini:</h3>
                <div class="max-h-40 overflow-y-auto space-y-2 pr-2 custom-scrollbar">
                    @forelse($instansis as $inst)
                        <div class="bg-slate-50 px-3 py-2.5 rounded border border-slate-200 text-sm text-slate-700 font-semibold flex items-center justify-between group hover:bg-white hover:border-slate-300 transition-colors">
                            <div class="flex items-center flex-1 mr-2 truncate">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 flex-shrink-0"></span>
                                <span class="truncate">{{ $inst->nama_instansi }}</span>
                            </div>
                            <div class="flex items-center space-x-1 flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" onclick="openEditModal('{{ $inst->id }}', '{{ $inst->nama_instansi }}')" class="text-slate-400 hover:text-blue-600 p-1.5 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('instansi.destroy', $inst->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 p-1.5 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">Belum ada data instansi.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 tracking-wide uppercase">Daftar Upacara & QR Code</h2>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($events as $event)
                        <div class="p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:bg-slate-50/50 transition-colors">
                            
                            <div class="space-y-2 flex-1">
                                <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm {{ $event->is_active ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                                    {{ $event->is_active ? '• Absensi Dibuka' : '• Absensi Ditutup' }}
                                </span>
                                <h3 class="text-xl font-bold text-blue-900 pt-1">{{ $event->nama_kegiatan }}</h3>
                                <p class="text-slate-500 text-sm flex items-center font-medium">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                                    <span class="mx-3 text-slate-300">|</span> 
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    {{ $event->attendances->count() }} Peserta Hadir
                                </p>
                                
                                <div class="pt-3 flex flex-wrap items-center gap-3">
                                    <form action="{{ route('admin.toggle', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold px-4 py-2 rounded-lg bg-white border border-slate-300 text-slate-600 hover:bg-slate-100 transition-colors shadow-sm">
                                            {{ $event->is_active ? 'Tutup Absen' : 'Buka Absen' }}
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('admin.rekap', $event->id) }}" class="text-xs font-bold px-4 py-2 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 hover:bg-blue-100 transition-colors shadow-sm flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Lihat Rekap & Ekspor
                                    </a>

                                    <a href="{{ route('absen.form', $event->id) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                        Lihat Form <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.destroy.event', $event->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus kegiatan akan menghapus SEMUA data absensi peserta di dalamnya. Yakin lanjut?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-xs font-bold px-4 py-2 rounded-lg bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition-colors shadow-sm flex items-center">
        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        Hapus Event
    </button>
</form>
                                </div>
                            </div>

                            <div class="flex flex-col items-center space-y-3 self-center md:self-auto no-print">
                                
                                <div id="qr-card-{{ $event->id }}" class="bg-white p-5 rounded-2xl shadow-[0_0_15px_rgba(0,0,0,0.05)] border-2 border-blue-100 flex flex-col items-center justify-center w-56 relative overflow-hidden">
                                    <div class="absolute top-0 left-0 w-full h-2 bg-blue-700"></div>
                                    
                                    <div class="mb-3 mt-2 text-center flex flex-col items-center">
                                        <img src="{{ asset('img/logo-pelindo.png') }}" alt="Logo Pelindo" class="h-7 w-auto object-contain mb-1">
                                        <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Absensi Upacara</div>
                                    </div>
                                    
                                    <div class="bg-white p-1 border border-slate-200 rounded-lg shadow-inner">
                                        {!! QrCode::size(140)->margin(0)->color(15, 23, 42)->generate(route('absen.form', $event->id)) !!}
                                    </div>
                                    
                                    <div class="mt-4 bg-blue-50 w-full py-2 rounded border border-blue-100 text-center">
                                        <span class="text-xs font-bold text-blue-800 tracking-wide uppercase">SCAN DI SINI</span>
                                    </div>
                                </div>

                                <button onclick="downloadQR('{{ $event->id }}', '{{ $event->nama_kegiatan }}')" class="w-full bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold py-2.5 px-4 rounded-lg shadow flex justify-center items-center transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download Print
                                </button>
                                
                            </div>

                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="inline-block p-4 rounded-full bg-blue-50 text-blue-300 mb-4">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Upacara</h3>
                            <p class="text-slate-500 text-sm">Silakan buat kegiatan upacara baru melalui form di sebelah kiri.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <div id="editModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md transform transition-transform duration-300 scale-95 overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo-pelindo.png') }}" alt="Logo Pelindo" class="h-8 w-auto object-contain">
                    <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide border-l-2 border-slate-200 pl-3">
                        Edit Instansi
                    </h2>
                </div>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-slate-500 text-xs font-bold mb-2 uppercase tracking-wider">Nama Instansi / Bagian</label>
                    <input type="text" id="editNamaInput" name="nama_instansi" class="w-full bg-slate-50 text-slate-800 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm" required>
                </div>
                
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-5 rounded-lg text-xs uppercase tracking-wider transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2.5 px-5 rounded-lg text-xs uppercase tracking-wider shadow transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>

    <script>
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        const input = document.getElementById('editNamaInput');

        function openEditModal(id, currentNama) {
            form.action = `/admin/instansi/${id}`;
            input.value = currentNama;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                modal.firstElementChild.classList.remove('scale-95');
                modal.firstElementChild.classList.add('scale-100');
            }, 10);
            setTimeout(() => input.focus(), 300);
        }

        function closeEditModal() {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            modal.firstElementChild.classList.remove('scale-100');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeEditModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeEditModal();
        });

        function downloadQR(eventId, eventName) {
            const qrCard = document.getElementById(`qr-card-${eventId}`);
            html2canvas(qrCard, {
                scale: 3, 
                backgroundColor: "#ffffff",
                useCORS: true
            }).then(canvas => {
                const image = canvas.toDataURL("image/png");
                const safeEventName = eventName.replace(/[^a-z0-9]/gi, '-').toLowerCase();
                const fileName = `QR-${safeEventName}.png`;
                const link = document.createElement('a');
                link.href = image; link.download = fileName;
                document.body.appendChild(link); link.click();
                document.body.removeChild(link);
            });
        }
    </script>
</body>
</html>