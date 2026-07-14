<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Instansi; 
use Illuminate\Support\Facades\Http; 
class EventController extends Controller
{
    // Menampilkan Dashboard Utama Admin
    public function index()
{
    $events = Event::with('attendances')->latest()->get();
    $instansis = Instansi::all(); // Ambil data instansi
    return view('admin.events', compact('events', 'instansis')); // Kirim ke view
}
public function storeInstansi(Request $request)
{
    $request->validate([
        'nama_instansi' => 'required|string|max:255',
    ]);

    Instansi::create([
        'nama_instansi' => $request->nama_instansi
    ]);

    return back()->with('success_instansi', 'Instansi / Bagian baru berhasil ditambahkan!');
}

    // Menyimpan Kegiatan Upacara Baru
   public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal' => 'required',
            'banner' => 'image|mimes:jpeg,png,jpg',
        ]);

        $bannerUrl = null;

        // JURUS TEMBAK LANGSUNG API CLOUDINARY
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            
            // Kredensial rahasia kamu
            $cloudName = 'dktmxduda';
            $apiKey = '344166586478737';
            $apiSecret = '0vdGgntEznTQXnPRMPnT9RVG7X0';
            $timestamp = time();
            
            // Buat kunci keamanan (Signature) wajib dari Cloudinary
            $signature = sha1('timestamp=' . $timestamp . $apiSecret);
            
            // Proses Upload langsung ke server Cloudinary
            $response = Http::attach(
                'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
            )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
            ]);

            // Ambil link gambarnya jika sukses
            if ($response->successful()) {
                $bannerUrl = $response->json()['secure_url'];
            } else {
                return back()->with('error', 'Gagal upload gambar ke Cloudinary!');
            }
        }

        Event::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'banner' => $bannerUrl,
            'is_active' => true
        ]);

        return back()->with('success', 'Kegiatan berhasil dibuat!');
    }


    // Mengubah Status Aktif/Nonaktif Absensi
    public function toggleStatus($id)
    {
        $event = Event::findOrFail($id);
        $event->is_active = !$event->is_active;
        $event->save();

        return back()->with('success', 'Status absensi berhasil diperbarui!');
    }
    // Menampilkan Halaman Rekap Peserta
    public function showRekap($id)
    {
        // Ambil data event beserta relasi attendances-nya
        $event = Event::with('attendances')->findOrFail($id);
        return view('admin.rekap', compact('event'));
    }

    // Ekspor Data ke Excel (CSV)
    public function exportExcel($id)
    {
        $event = Event::with('attendances')->findOrFail($id);
        $fileName = 'Rekap_Absen_' . str_replace(' ', '_', $event->nama_kegiatan) . '.csv';

        // Header agar browser membaca ini sebagai file donwload Excel/CSV
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Nama-nama Kolom di Excel
        $columns = ['No', 'Nama Lengkap', 'NIP', 'Instansi/Bagian', 'Waktu Absen', 'Latitude', 'Longitude'];

        // Proses tulis data
        $callback = function() use($event, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $no = 1;
            foreach ($event->attendances as $row) {
                fputcsv($file, [
                    $no++,
                    $row->nama,
                    $row->nip,
                    $row->instansi,
                    $row->created_at->format('d-m-Y H:i:s'),
                    $row->latitude,
                    $row->longitude
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    // Menghapus Instansi
    public function destroyInstansi($id)
    {
        $instansi = \App\Models\Instansi::findOrFail($id);
        $instansi->delete();

        return back()->with('success_instansi', 'Data Instansi berhasil dihapus!');
    }
    // Memperbarui Data Instansi
    public function updateInstansi(Request $request, $id)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255',
        ]);

        $instansi = \App\Models\Instansi::findOrFail($id);
        $instansi->update([
            'nama_instansi' => $request->nama_instansi
        ]);

        return back()->with('success_instansi', 'Nama Instansi berhasil diperbarui!');
    }
    public function destroyEvent($id)
{
    $event = \App\Models\Event::findOrFail($id);
    
    // Opsional: Hapus file banner kalau ada
    if ($event->banner) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($event->banner);
    }
    
    $event->delete();

    return back()->with('success', 'Kegiatan upacara berhasil dihapus!');
}
}
