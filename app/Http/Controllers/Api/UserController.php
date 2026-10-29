<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        try{
            return UserResource::collection($this->userService->getAll(
                (int) $request->query('per_page', 10)));  
        }catch(Throwable $e){
            return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR,'message' => 'Failed to fetch users',
            'data' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }


    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->create($request->validated());

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'message' => 'User created successfully',
                'data' => new UserResource($user),
            ], Response::HTTP_CREATED);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to create user',
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $user): JsonResponse
    {
        try {
            $userData = $this->userService->getById($user);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'User retrieved successfully',
                'data' => new UserResource($userData),
            ], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found',
                'data' => [],
            ], Response::HTTP_NOT_FOUND);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to retrieve user',
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateUserRequest $request, int $user): JsonResponse
    {
        try {
            $userData = $this->userService->update($user,$request->validated());

            return response()->json(['status' => Response::HTTP_OK,
            'message' => 'User updated successfully','data' => new UserResource($userData)], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => Response::HTTP_NOT_FOUND,'message' => 'User not found','data' => [],], Response::HTTP_NOT_FOUND);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to update user',
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $user): JsonResponse
    {
        try {
            $this->userService->delete($user);

            return response()->json(['status' => Response::HTTP_OK,'message' => 'Successfully deleted',
            'data' => []], Response::HTTP_OK);

        } catch (Throwable $e) {
            return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR,'message' => 'Failed to delete user',
            'data' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}