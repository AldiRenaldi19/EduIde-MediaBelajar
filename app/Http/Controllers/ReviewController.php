<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan baru yang dikirim melalui modal di Landing Page.
     * Menggunakan validasi ketat untuk menjaga integritas data.
     */
    public function store(Request $request)
    {
        // Validasi input: memastikan nama dan pekerjaan tidak terlalu panjang, 
        // serta pesan tidak kosong untuk menjaga kerapihan UI slider.
        $validated = $request->validate([
            'name'    => 'required|string|max:50',
            'job'     => 'required|string|max:50',
            'message' => 'required|string|max:500',
            'rating'  => 'nullable|integer|min:1|max:5',
        ]);

        // Menyimpan data ke database menggunakan data yang sudah tervalidasi
        Review::create($validated);

        // Kembali ke halaman sebelumnya dengan pesan sukses (toast/alert)
        return back()->with('success', 'Aspirasi Anda telah terekam dalam sistem kami!');
    }
}
