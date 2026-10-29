<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'from_account_id' => $this->from_account_id,
            'to_account_id' => $this->to_account_id,
            'amount' => $this->amount,
            'status' => $this->status,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
        ];
    }
}