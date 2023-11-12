<?php

namespace App\Classes\Enums;

enum DocumentType: int
{
    case CEDULA = 1;
    case NIT = 2;
    case CEDULA_EXTRANJERA = 3;
}
