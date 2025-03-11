<?php

namespace App\Http\Controllers\auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * Crear una nueva instancia del AuthController.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    /**
     * Iniciar sesión y obtener un token JWT.
     *
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Iniciar sesión",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas"
     *     )
     * )
     */
    public function login()
    {
        $credentials = request(['dni', 'password']);
        try {
            if (! $token = auth()->attempt($credentials)) {
                return $this->sendError('Credenciales incorrectas', 401);
            }

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = User::create($validated);
            $user->assignRole('trabajador');

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente.',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener el usuario autenticado.
     *
     * @OA\Get(
     *     path="/api/auth/me",
     *     summary="Obtener usuario autenticado",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Usuario autenticado",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     )
     * )
     */
    public function me()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                throw new \Exception('Usuario no autenticado.');
            }

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'email' => $user->email,
                    'dni' => $user->dni,
                    'phone' => $user->phone,
                    'status' => $user->status,
                    'birth_date' => $user->birth_date,
                    'created_at' => $user->created_at,
                ],
                'roles' => $user->getRoleNames(), 
                'permissions' => $user->getAllPermissions()->pluck('name'), 
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => 401, // Código de error específico
            ], 401);
        }
    }



    /**
     * Cerrar sesión y invalidar el token.
     *
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Cerrar sesión",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Cierre de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refrescar el token JWT.
     *
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Refrescar token",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token renovado",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Estructura de respuesta del token.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
