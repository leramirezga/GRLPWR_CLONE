<?php

namespace App\Notifications;

use App\Model\SolicitudServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfertaAceptada extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;
    private $solicitud;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SolicitudServicio $solicitudServicio)
    {
        $this->solicitud = $solicitudServicio;
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
            'link' => env('APP_URL'),//TODO COLOCAR UNA PAGINA DONDE SE VEAN LOS ENTRENAMIENTOS CANCELADOS.
            'mensaje' => 'Felicitaciones has sido contratado para un entrenamiento',
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
        $data = [
            'data' => [
                'link' => env('APP_URL'),//TODO COLOCAR UNA PAGINA DONDE SE VEAN LOS ENTRENAMIENTOS CANCELADOS.
                'mensaje' => 'Felicitaciones has sido contratado para un entrenamiento',
                'solicitud' => $this->solicitud,
            ]
        ];
        return (new BroadcastMessage($data));
    }
}
