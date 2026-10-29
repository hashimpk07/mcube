<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to_user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
            ],
        ];
    }
}