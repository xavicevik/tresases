<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class EmailcodeNotification extends Notification
{
    public function __construct($subject, $line1, $action, $line2, $numero, $promocional)
    {
        $this->numero = $numero;
        $this->promocional = $promocional;
        $this->subject = $subject;
        $this->line1 = $line1;
        $this->action = $action;
        $this->line2 = $line2;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__($this->subject))
            ->line(__($this->line1))
            ->action(__($this->action),'')
            ->line(__($this->line2));
    }
}
