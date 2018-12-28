<?php

namespace App\Notifications;

use App\Channels\SocketChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MirrorUninstalledModule extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param $mirror
     * @param $user
     * @param $accessToken
     */
    public function __construct($mirror, $user, $module)
    {
        $this->mirror = $mirror;
        $this->user = $user;
        $this->module = $module;
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
            'to'              => "module",
            'action'          => "uninstall",
            'mirror'          => $this->mirror,
            'user'            => $this->user,
            'module'         => $this->module
        ];
    }
}
