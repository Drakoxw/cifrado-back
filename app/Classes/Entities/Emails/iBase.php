<?php

namespace App\Classes\Entities\Emails;

interface iBase
{
    public function setSubject(string $subject);

    public function setTemplate(string $template);

    public function setToEmail(string $toEmail);
}
