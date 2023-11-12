<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Classes\Mails\TestEmail\DataTestEmail;

class EmailTest extends TestCase
{

    public function test_email() {
        $email =  new DataTestEmail('Prueba de correo');
        $email->toEmail = 'drakowdev@gmail.com';
        Mail::to($email->toEmail)->send(new \App\Mail\Generic($email));
        $this->assertTrue(true);
    }
}
