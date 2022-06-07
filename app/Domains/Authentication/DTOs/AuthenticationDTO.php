<?php

namespace App\Domains\Authentication\DTOs;

class AuthenticationDTO
{
    public function __construct(
        public string $username,
        public string $password,
        public ?string $email = null
    ) {}
}
