<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Your Bradford Council Map Password')
            ->greeting('Hello!')
            ->line('You requested a password reset for your Bradford Council account.')
            ->action('Reset Password', url('/reset-password/' . $this->token))
            ->line('This password reset link will expire in 15 minutes.')
            ->line('If you didn\'t request this, please ignore this message.')
            ->salutation('Regards, City of Bradford Metropolitan District Council');
    }
}
