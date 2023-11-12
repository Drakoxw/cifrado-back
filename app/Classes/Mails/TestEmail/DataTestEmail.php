<?php

namespace App\Classes\Mails\TestEmail;

use App\Classes\Mails\Base;

class DataTestEmail extends Base
{
    public string $user;

    public function __construct(string $user)
    {
        $this->user = $user;
        $this->get();
    }

    public function get(): DataTestEmail
    {
        $template = new TemplateTest($this->user);
        $this->subject = "Test de email";
        $this->template = $template->render();

        return $this;
    }
}
