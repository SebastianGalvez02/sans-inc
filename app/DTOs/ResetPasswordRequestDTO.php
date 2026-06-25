<?php

namespace App\DTOs;

use App\Support\PasswordRules;
use Illuminate\Http\Request;

class ResetPasswordRequestDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $code,
        public readonly string $password,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $rules = array_merge(
            ['required', 'confirmed'],
            PasswordRules::strong()
        );

        $request->validate([
            'email'    => 'required|string|email|max:100',
            'code'     => 'required|string|digits:6',
            'password' => $rules,
        ]);

        return new self($request->email, $request->code, $request->password);
    }
}
