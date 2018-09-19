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
        try {
            $client = new Client(new Version2X(config("app.url") . ":4224"));
            $client->initialize();
            $client->emit($message['to'], $message);
            $client->close();
        } catch (\Exception $exception) {
        }
    }
}