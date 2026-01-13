<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller aplikasi.
 *
 * Semua controller lain mewarisi kelas ini agar:
 * - bisa menggunakan helper bawaan Laravel (seperti middleware(), authorize(), validate(), dll),
 * - konsisten dalam otorisasi dan validasi request.
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
