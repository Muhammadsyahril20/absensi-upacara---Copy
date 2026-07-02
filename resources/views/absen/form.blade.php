<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Absensi Upacara - Pelindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar untuk mobile */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-slate-100 h-full font-sans text-slate-800 selection:bg-blue-200">

    <div class="h-screen w-full flex items-center justify-center p-4 overflow-y-auto">
        
        <div class="glass-panel w-full max-w-md rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.1)] border border-white overflow-hidden my-auto">
            
            @if($event->banner)
                <div class="relative w-full h-40">
<img src="{{ $event->banner }}" alt="Banner Upacara" ...>                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            @endif

            <div class="p-6 sm:p-8">
                <div class="text-center mb-8">
                    <img src="{{ asset('img/logo-pelindo.png') }}" alt="Pelindo" class="h-10 mx-auto mb-4 object-contain">
                    <h2 class="text-xl font-black text-blue-900 uppercase tracking-wide">Absensi Kehadiran</h2>
                    <span class="inline-block mt-2 text-xs font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-widest">
                        {{ $event->nama_kegiatan }}
                    </span>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded-xl text-sm font-bold text-center mb-6 border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-4 rounded-xl text-sm font-bold text-center mb-6 border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('absen.store', $event->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" id="lat" name="lat">
                    <input type="hidden" id="lng" name="lng">

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Tuliskan nama Anda" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 mt-1 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">NIP</label>
                        <input type="text" name="nip" placeholder="Contoh: 12345678" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 mt-1 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Instansi / Bagian</label>
                        <select name="instansi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 mt-1 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all" required>
                            <option value="" disabled selected>Pilih Instansi</option>
                            @foreach($instansis as $inst)
                                <option value="{{ $inst->nama_instansi }}">{{ $inst->nama_instansi }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(isset($closed))
    <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-xl mb-6 text-sm font-bold text-center flex items-center justify-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        Mohon maaf, absensi untuk kegiatan ini sudah ditutup.
    </div>
@endif

@if(isset($closed))
    <button type="button" class="w-full bg-slate-200 text-slate-500 font-bold py-3.5 px-4 rounded-xl cursor-not-allowed mt-6 shadow-sm uppercase tracking-widest text-xs" disabled>
        Absensi Ditutup
    </button>
@else
    <button type="submit" id="btnSubmit" class="w-full bg-slate-200 text-slate-500 font-bold py-3.5 px-4 rounded-xl cursor-not-allowed mt-6 flex justify-center items-center transition-all duration-300 shadow-sm" disabled>
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-400" id="loadingIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span id="btnText" class="tracking-wide">Mendeteksi Lokasi...</span>
    </button>
@endif
                </form>

                <p class="text-[10px] text-center text-slate-400 mt-8 uppercase font-bold">PT Pelindo - Divisi Umum</p>
            </div>
        </div>
    </div>

    <script>
        // Memaksa akses lokasi dengan akurasi tinggi
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                document.getElementById("lat").value = pos.coords.latitude;
                document.getElementById("lng").value = pos.coords.longitude;
                
                const btn = document.getElementById("btnSubmit");
                btn.disabled = false;
                btn.classList.remove("bg-slate-200", "text-slate-500");
                btn.classList.add("bg-blue-700", "text-white", "hover:bg-blue-800", "shadow-lg");
                document.getElementById("btnText").innerText = "Hadir & Simpan Absen";
            },
            (err) => {
                const btn = document.getElementById("btnSubmit");
                btn.classList.add("bg-red-500", "text-white");
                document.getElementById("btnText").innerText = "Akses Lokasi Ditolak";
                alert("Mohon izinkan akses lokasi (GPS) untuk absen!");
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    </script>
</body>
</html>