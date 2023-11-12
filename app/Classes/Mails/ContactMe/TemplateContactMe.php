<?php
namespace App\Classes\Mails\ContactMe;
use App\Classes\Entities\Emails\iTemplate;
use Carbon\Carbon;

class TemplateContactMe implements iTemplate
{
    /** Datos del usuario */
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function render(): string
    {
        $data = $this->data;
        $data['year'] = Carbon::now()->format('Y');
        $template = view('mails.contact-me', $data)->render();

        return $template;
    }
}
