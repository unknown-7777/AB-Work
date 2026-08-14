<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {

        return auth()->user()->isClient();
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'min:10', 'max:150'],
            'description'      => ['required', 'string', 'min:10'],
            'category_id'      => ['required', 'exists:categories,id'],
            'budget_type'      => ['required', 'in:fixed,hourly'],
            'budget_min'       => ['required', 'numeric', 'min:1'],
            'budget_max'       => ['nullable', 'numeric', 'gte:budget_min'],
            'experience_level' => ['required', 'in:entry,intermediate,expert'],
            'project_length'   => ['nullable', 'in:short,medium,long'],
            'required_skills'  => ['nullable', 'string'],
            'deadline'         => ['nullable', 'date', 'after:today'],
        ];
    }
}