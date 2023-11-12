<?php

namespace App\Http\Controllers\Mails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ControllerExt;
use App\Classes\Mails\TestEmail\DataTestEmail;
use App\Services\Validations;

class TestMailController extends ControllerExt
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            Validations::TestEmail($request);
            $email =  new DataTestEmail('Prueba de correo');
            $to = $request->get('email');
            $email->toEmail = $to;
            Mail::to($email->toEmail)->send(new \App\Mail\Generic($email));

            return $this->responseOk(['sendTo' => $to, 'message' => 'Correo enviado correctamente']);

        } catch (\Throwable $e) {
            return $this->badResponse($e);
        }
    }
}
