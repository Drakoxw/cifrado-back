<?php

namespace App\Classes\DTOs;

class AuthDTO {

    public string $userName;

    public string $email;

    public string $rol;

    public int $idInternal;

    public int $idUser;

    public string $token;

    public function __construct(string $userName, string $email, string $rol, int $idInternal, int $idUser, string $token) {
        $this->userName   = $userName;
        $this->email      = $email;
        $this->rol        = $rol;
        $this->idInternal = $idInternal;
        $this->idUser     = $idUser;
        $this->token      = $token;
    }

}
