<?php

namespace App\Classes\Entities\Emails;

interface iTemplate
{
    public function render(): string;
}
