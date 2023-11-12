<?php
namespace App\Classes\Mails\ContactMe;

use App\Classes\Mails\Base;

class EmailContactMe extends Base
{
    /** Nombre completo del usuario */
    private string $fullName;

    /** Email del usuario */
    private string $email;

    /** Telefono del usuario */
    private int $phone;

    /** Mensaje del usuario */
    private string $message;

    public function __construct(string $fullName, string $email, int $phone, string $message, string $subject)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
        $this->subject = $subject;
    }

    public function get(): EmailContactMe
    {
        $template = new TemplateContactMe([
            'fullname' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message
        ]);
        $this->template = $template->render();

        return $this;
    }

}
