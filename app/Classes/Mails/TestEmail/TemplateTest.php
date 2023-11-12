<?php

namespace App\Classes\Mails\TestEmail;

use App\Classes\Entities\Emails\iTemplate;
use Carbon\Carbon;

class TemplateTest implements iTemplate
{
    private string $user;

    public function __construct(string $user)
    {
        $this->user = $user;
    }

    public function render(): string
    {
        $data = [
            'user' => $this->user,
            'year' => Carbon::now()->format('Y'),
        ];
        $template = view('test', $data)->render();

        return $template;
    }
}
