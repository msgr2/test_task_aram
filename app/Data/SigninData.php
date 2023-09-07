<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class SigninData extends Data
{
    public function __construct(
        public string $email,
        public string $password,
        public bool   $remember,
    )
    {
    }
}
