<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class ForgotPasswordRequestDTO
{
    public function __construct(
        public readonly string $email,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $request->validate([
            'email' => 'required|string|email|max:100',
        ]);

        return new self($request->email);
    }
}
