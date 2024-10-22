<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInitPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $code;
    private $hash;
    private $from;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data['code'] = $this->code;
        $data['name'] = $notifiable->name;
        $data['header_text'] = 'كلمة المرور المبدئية الخاصة بك';
        return (new MailMessage)
            ->view('mail.send_code', $data)
            ->subject('كلمة المرور المبدئية')
            ->from('info@tadreesacademy.com');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
