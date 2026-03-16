<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loaned_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:loaned_at',
            'returned_at' => 'nullable|date|after_or_equal:loaned_at',
            'notes' => 'nullable|string',
        ];
    }
}
