<?php

namespace App\Classes\Mails;

use App\Classes\Entities\Emails\iBase;
use Exception;

class Base implements iBase
{
    public string $toEmail;

    public string $template;

    public string $subject;

    public function setSubject(string $subject)
    {
        if (! is_string($subject)) {
            throw new Exception('Attribute Error:subject is not a string');
        }
        $this->subject = $subject;
    }

    public function setTemplate(string $template)
    {
        if (! is_string($template)) {
            throw new Exception('Attribute Error:template is not a string');
        }
        $this->template = $template;
    }

    public function setToEmail(string $toEmail)
    {
        if (! is_string($toEmail)) {
            throw new Exception('Attribute Error:toEmail is not a string');
        }
        $this->toEmail = $toEmail;
    }

    /** Metodo q deden implementar las clases hijas, para renderizar los templates */
    public function get()
    {
    }
}
