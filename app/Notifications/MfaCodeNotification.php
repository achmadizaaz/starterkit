<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MfaCodeNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly string $code)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode verifikasi login')
            ->greeting('Halo '.$notifiable->name)
            ->line('Gunakan kode berikut untuk menyelesaikan proses login.')
            ->line('Kode MFA: '.$this->code)
            ->line('Kode berlaku selama 10 menit.')
            ->line('Abaikan email ini jika Anda tidak sedang login.');
    }
}
