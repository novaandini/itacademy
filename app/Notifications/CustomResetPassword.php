<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordNotification
{
    public function toMail($notifiable)
    {
        // Buat email reset password
        return (new MailMessage)
                    ->from($notifiable->email, $notifiable->name) // Alamat pengirim diambil dari user terdaftar
                    ->subject('Reset Password Notification')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', url(config('app.url').route('password.reset', $this->token, false)))
                    ->line('If you did not request a password reset, no further action is required.');
    }
}
