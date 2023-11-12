<?php

namespace App\Classes\Enums;

enum PrefixBase64: string
{
    case PDF = 'data:application/pdf;base64,';
    case DOC = 'data:application/msword;base64,';
    case PNG = 'data:image/png;base64,';
    case XLSX = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,';
    case JPEG = 'data:image/jpeg;base64,';
    case ICO = 'data:image/x-icon;base64,';
}
