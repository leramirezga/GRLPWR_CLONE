<?php

namespace App\Http\Services;

use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements SendMessageInterface
{

    public function sendMessage($info)
    {
        Log::info("Enviando mensaje de renovación de plan, al telefono, " . $info->cellphone);
        $response = Http::withToken(env('WHATSAPP_TOKEN', 'EAAYtwx6pwEIBO2kuMIVzPZAAE4YkcUxLNMIuZAiASqnbwjR83XW1dgmUdZCI049vTK3ImX6VTZALPUrxdFdtroV3Hc9NcTLzZB6bSPMHCwf6XtelpjeHbFYHFwFPqPRKzBzH0bTRYNegb26w3xzpRzN183JzbfGtTqwpTbyy6vPTif9UmgtBQ7G85F4LON7Sd7xRCJRgMXxyIeInL0cMoTG4h1ohPv1EZD'))
            ->post('https://graph.facebook.com/v19.0/240659882462097/messages',
                [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => '+57'.$info->cellphone,
                    'type' => 'template',
                    'template' => [
                        'name' => 'notificacion_expiracion_plan',
                        'language' => [
                            'code' => 'es'
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    [
                                        'type' => 'text',
                                        'text' => $info->expiration_date->translatedFormat('l j \d\e F \d\e Y')
                                    ],
                                    [
                                        'type' => 'text',
                                        'text' => '10%'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
        dd($response);
    }
}