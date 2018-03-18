<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Channels\SocketChannel;
use Illuminate\Notifications\Messages\MailMessage;

class MirrorLinked extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mirrorId, $userId, $accessToken)
    {
        $this->mirrorId = $mirrorId;
        $this->userId = $userId;
        $this->accessToken = $accessToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SocketChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toSocket($notifiable)
    {
        return [
            'to'              => "linked",
            'mirror_id'       => $this->mirrorId,
            'access_token'    => $this->accessToken,
            'user_id'         => $this->userId
        ];
    }
}
