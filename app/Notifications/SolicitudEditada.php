<?php

namespace App\Notifications;

use App\Model\SolicitudServicio;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudEditada extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public $solicitud;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SolicitudServicio $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
    public function toDataBase($notifiable)
    {
        return [
            'link' => 'ofertar/'.$this->solicitud->id,
            'mensaje' => 'Han modificado una solicitud en que estás participando',
            'solicitud' => $this->solicitud,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        /*return new BroadcastMessage([
            'solicitud' => $notifiable,
        ]);*/
        return [
            'data' => [
                'link' => 'ofertar/'.$this->solicitud->id,
                'mensaje' => 'Han modificado una solicitud en que estás participando',
                'solicitud' => $this->solicitud,
            ]
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     *
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.2');
    }*/
}
