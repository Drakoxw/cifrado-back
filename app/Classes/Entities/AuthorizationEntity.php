<?php

namespace App\Classes\Entities;

class AuthorizationEntity
{
    public string $ip;

    /** @var string NOMBRE COMPLETO */
    public string $name;

    /** @var string NOMBRE DE USUARIO/NICKNAME  */
    public string $login;

    public string $email;

    public string $idUser;

    public string $idInternal;

    public string $rol;

    public bool $isAdmin = false;

    public function __construct(array $token)
    {
        $this->ip         = $token['ip'];
        $this->name       = $token['name'];
        $this->login      = $token['login'];
        $this->email      = $token['email'];
        $this->idUser     = $token['idUser'];
        $this->idInternal = $token['idInternal'];
        $this->rol        = $token['rol'];
        $this->isAdmin    = (bool)$token['isAdmin'];
    }
}
