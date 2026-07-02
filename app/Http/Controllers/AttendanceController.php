<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Attendance;
use App\Models\Instansi;

class AttendanceController extends Controller
{
    // Menampilkan Form Absen berdasarkan ID Kegiatan
   public function showForm($id)
{
    $event = Event::findOrFail($id);
    $instansis = Instansi::all();

    // Cek apakah aktif
    if (!$event->is_active) {
        // Kirim status ke view bahwa ini sudah tutup
        return view('absen.form', compact('event', 'instansis'))->with('closed', true);
    }
    
    return view('absen.form', compact('event', 'instansis'));
}

    // Proses Submit Data
    public function store(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'instansi' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        // Kordinat Pusat Kantor Pelindo (Ganti dengan kordinat akurat kantormu)
        $kantor_lat = 1.677312; // Contoh Latitude
        $kantor_lng = 101.455062; // Contoh Longitude

        // Hitung jarak menggunakan rumus Haversine
        $jarak = $this->hitungJarak($kantor_lat, $kantor_lng, $request->lat, $request->lng);

        // Batas maksimal 100 meter (0.1 kilometer)
        if ($jarak > 0.1) {
            return back()->with('error', 'Anda berada di luar area upacara! Jarak Anda: ' . round($jarak * 1000) . ' meter.');
        }

        Attendance::create([
            'event_id' => $id,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'instansi' => $request->instansi,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
        ]);

        return back()->with('success', 'Berhasil melakukan absensi!');
    }

    // Fungsi menghitung jarak dalam Kilometer
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344); // Ubah ke Kilometer
    }
}
