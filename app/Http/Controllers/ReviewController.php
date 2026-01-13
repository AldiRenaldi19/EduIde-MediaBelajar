<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan baru yang dikirim melalui modal di Landing Page.
     * Menggunakan validasi ketat untuk menjaga integritas data.
     */
    public function store(StoreReviewRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Validasi input dihandle oleh StoreReviewRequest

        // Menyimpan data ke database menggunakan data yang sudah tervalidasi
        Review::create($request->validated());

        // Kembali ke halaman sebelumnya dengan pesan sukses (toast/alert)
        return back()->with('success', 'Aspirasi Anda telah terekam dalam sistem kami!');
    }
}
