<?php

namespace App\Http\Controllers\Mails;

use Illuminate\Http\Request;
use App\Services\Validations;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ControllerExt;
use App\Classes\Mails\ContactMe\EmailContactMe;

class ContactMeController extends ControllerExt
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
            Validations::ContactMe($request);
            $email = new EmailContactMe(
                $request->fullname,
                $request->email,
                (int)$request->phone,
                $request->message,
                $request->subject
            );
            $email->toEmail = 'drakowdev@gmail.com';
            Mail::to($email->toEmail)->send(new \App\Mail\Generic($email));
            return $this->responseOk([],'Correo enviado correctamente');

        } catch (\Throwable $e) {
            return $this->badResponse($e);
        }
    }
}
