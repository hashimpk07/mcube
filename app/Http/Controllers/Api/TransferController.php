<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\BankTransactionResource;
use App\Services\TransferService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

class TransferController extends Controller
{
    public function __construct(
        private TransferService $service
    ) {}

    public function store(TransferRequest $request): JsonResponse
    {
        try {
            $transaction = $this->service->transfer(
                (int) $request->user()->id,
                (int) $request->validated('to_user_id'),
                (string) $request->validated('amount')
            );

            return response()->json([
                'status' => 200,
                'message' => 'Money transferred successfully.',
                'data' => new BankTransactionResource($transaction),
            ]);
        } catch (DomainException $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
                'data' => null,
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Sender or receiver bank account not found.',
                'data' => null,
            ], 404);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => 500,
                'message' => 'Unable to transfer money.',
                'data' => null,
            ], 500);
        }
    }
}