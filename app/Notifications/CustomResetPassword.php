<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordNotification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pemulihan Kata Sandi - EduIde')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun EduIde Anda.')
            ->action('Atur Ulang Kata Sandi', url(config('app.url') . route('password.reset', $this->token, false) . '?email=' . $notifiable->getEmailForPasswordReset()))
            ->line('Tautan ini akan kedaluwarsa dalam 60 menit.')
            ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.')
            ->salutation('Salam hangat, Tim EduIde');
    }
}
