<?php

namespace App\Notifications;

use App\Channels\SocketChannel;
use App\Mirror;
use App\ModuleVersion;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MirrorInstalledModuleConfigUpdated extends Notification
{
  use Queueable;
  /**
   * @var Mirror
   */
  private $mirror;
  /**
   * @var ModuleVersion
   */
  private $moduleVersion;

  /**
   * @var User
   */
  private $user;

  private $config;

  /**
   * Create a new notification instance.
   *
   * @param Mirror $mirror
   * @param ModuleVersion $moduleVersion
   * @param User $user
   * @param $config
   */
  public function __construct(Mirror $mirror, ModuleVersion $moduleVersion, User $user, $config)
  {
    //
    $this->mirror = $mirror;
    $this->moduleVersion = $moduleVersion;
    $this->config = $config;
    $this->user = $user;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return [SocketChannel::class];
  }

  public function toSocket($notifiable)
  {
    return [
        'to' => "module_config_updated",
        'mirror' => $this->mirror,
        'module' => $this->moduleVersion->module,
        'user' => $this->user,
        'config' => $this->config
    ];
  }
}
