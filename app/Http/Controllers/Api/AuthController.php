<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ], Response::HTTP_CREATED);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Registration failed',
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Authenticate a user and generate an API token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $user = User::where('email', $data['email'])->first();

            if (
                !$user ||
                !Hash::check($data['password'], $user->password)
            ) {
                return response()->json([
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Invalid email or password',
                    'data' => [],
                ], Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Login successful',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ], Response::HTTP_OK);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Login failed',
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Logout the authenticated user from the current API token.
     */
    public function logout(): JsonResponse
    {
        $user = request()->user();
        $token = $user?->currentAccessToken();

        if ($token && method_exists($token, 'delete')) {
            $token->delete();
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Logout successful',
            'data' => [],
        ], Response::HTTP_OK);
    }

    /**
     * Return the authenticated user's details.
     */
    public function me(): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'User retrieved successfully',
            'data' => new UserResource(request()->user()),
        ], Response::HTTP_OK);
    }
}