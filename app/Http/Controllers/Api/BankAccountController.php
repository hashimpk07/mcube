<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Resources\BankAccountResource;
use App\Services\BankAccountService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

class BankAccountController extends Controller
{
    public function __construct(
        private BankAccountService $service
    ) {}

    public function store(
        StoreBankAccountRequest $request
    ): JsonResponse {
        try {
            $account = $this->service->createAccount(
                (int) $request->user()->id
            );

            return response()->json([
                'status' => 201,
                'message' => 'Bank account created successfully.',
                'data' => new BankAccountResource($account),
            ], 201);
        } catch (DomainException $e) {
            return response()->json([
                'status' => 409,
                'message' => $e->getMessage(),
                'data' => null,
            ], 409);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => 500,
                'message' => 'Unable to create bank account.',
                'data' => null,
            ], 500);
        }
    }

    public function myBalance(): JsonResponse
    {
        try {
            $account = $this->service->getBalance(
                (int) request()->user()->id
            );

            return response()->json([
                'status' => 200,
                'message' => 'Balance retrieved successfully.',
                'data' => new BankAccountResource($account),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Bank account not found.',
                'data' => null,
            ], 404);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => 500,
                'message' => 'Unable to retrieve balance.',
                'data' => null,
            ], 500);
        }
    }
}