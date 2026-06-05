<?php

namespace App\DTOs;

class RegisterRequestDTO
{
    public string $name;
    public string $email;
    public string $password;
    public int $role_id;

    public function __construct(string $name, string $email, string $password, int $role_id)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
    }
}
