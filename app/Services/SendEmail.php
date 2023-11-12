<?php

namespace App\Services;

use App\Classes\Mails\Base;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Response;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendEmail implements ShouldQueue
{
    use Queueable, SerializesModels;

    public static $url = 'https://aveonline.co/api/comunes/v1.0/email.php';

    public static $body = [
        'tipo' => 'enviarEmail',
        'key' => '4p0EF8M!YT&S6ftg0p4K1WtN',
        'asunto' => 'no-reply@aveonline.co -noreply',
        'destino' => 'no@aveonline.co',
        'template' => '<h1>Hola mundo</h1>',
    ];

    /**
     * Metodo para el vio desde api-old
     */
    public static function main(string $email, string $template, string $subject = ''): Response
    {
        $data = self::$body;
        $data['template'] = $template;
        $data['destino'] = $email;
        $data['asunto'] = $subject ?? $data['asunto'];

        return Http::post(self::$url, $data);
    }

    /**
     * Metodo que envia desde api old pero sin esperar respuesta
     */
    public static function lancher(Base $dataEmail, $timeOut = 1): void
    {
        $data = self::$body;
        $data['template'] = $dataEmail->template;
        $data['destino'] = $dataEmail->toEmail;
        $data['asunto'] = $dataEmail->subject;

        try {
            Http::acceptJson()
                ->contentType('application/json')
                ->timeout($timeOut)->post(self::$url, $data);
        } catch (\Throwable $e) {
            //falla a proposito por cancelacion en tiempo de espera
            return;
        }
    }
}
