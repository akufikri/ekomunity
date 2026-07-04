<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verifyUrl = config('app.url') . '/verify_email?id=' . $notifiable->id;

        return (new MailMessage)
            ->subject('Sahkan Alamat E-mel Anda - Ekomuniti')
            ->greeting('Assalamualaikum, ' . $notifiable->fullname . '!')
            ->line('Terima kasih kerana mendaftar di Ekomuniti.')
            ->line('Sila klik butang di bawah untuk mengesahkan alamat e-mel anda.')
            ->action('Sahkan E-mel', $verifyUrl)
            ->line('Jika anda tidak mendaftar akaun ini, abaikan e-mel ini.')
            ->salutation('Sekian, Pasukan Ekomuniti');
    }
}
