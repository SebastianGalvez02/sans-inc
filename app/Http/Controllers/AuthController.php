<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\UserRepository;
use App\DTOs\RegisterRequestDTO;
use App\DTOs\RegisterResponseDTO;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        // 1. Validar datos de entrada (AuthController.register -> Validaciones)
        $request->validate([
            'name' => 'required|string|max:16',
            'email' => 'required|string|email|max:100',
            'role_id' => 'required|exists:roles,id',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        // 2. Mapear al DTO de entrada
        $requestDTO = new RegisterRequestDTO(
            $request->name,
            $request->email,
            $request->password,
            $request->role_id
        );

        // 3. Verificar que el correo no exista (Devolver 409 Conflict)
        if ($this->userRepository->existsByEmail($requestDTO->email)) {
            return response()->json(['message' => 'Email already registered'], 409);
        }

        // 4. Crear Entidad y Hash de contraseña
        $user = new User();
        $user->name = $requestDTO->name;
        $user->email = $requestDTO->email;
        $user->password = Hash::make($requestDTO->password);
        $user->role_id = $requestDTO->role_id;

        // 5. Guardar usuario en BD
        $savedUser = $this->userRepository->save($user);

        // 6. Retornar respuesta exitosa (201 Created) con el ResponseDTO
        $responseDTO = new RegisterResponseDTO($savedUser);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $responseDTO
        ], 201);
    }
}
