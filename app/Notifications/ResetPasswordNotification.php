<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $resetUrl;

    /**
     * Create a new notification instance.
     *
     * @param string $resetUrl
     */
    public function __construct($resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Generate the reset password URL
        $url = $this->resetUrl;

        return (new MailMessage)
            ->line('Anda mendapatkan email ini karena meminta reset password pada website pesonasimarasok.pnp.ac.id')
            ->action('Reset Password', $url)
            ->line('Jika Anda tidak meminta ini, abaikan pesan ini');
    }
}
