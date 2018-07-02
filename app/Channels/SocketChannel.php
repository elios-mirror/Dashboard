<?php

namespace App\Channels;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use Illuminate\Notifications\Notification;
class SocketChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSocket($notifiable);
        $client = new Client(new Version2X("http://dev.elios-mirror.com:4224"));
        $client->initialize();
        $client->emit($message['to'], $message);
        $client->close();
    }
}