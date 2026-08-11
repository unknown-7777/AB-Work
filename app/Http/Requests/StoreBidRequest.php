<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isFreelancer();
    }

    public function rules(): array
    {
        return [
            'amount'        => ['required', 'numeric', 'min:1'],
            'delivery_days' => ['required', 'integer', 'min:1'],
            'cover_letter'  => ['required', 'string', 'min:50'],
        ];
    }
}