<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     * Ditambahkan 'is_admin' untuk kontrol akses dashboard.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'google_id',
        'avatar',
    ];

    /**
     * Atribut yang disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * Casting atribut ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // Memastikan is_admin selalu dibaca sebagai true/false
    ];

    /**
     * Relasi Many-to-Many ke Model Course.
     * Digunakan untuk fitur 'Kursus Saya' dan pendaftaran (Enroll).
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps();
    }
}
