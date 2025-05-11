<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assessment_id' => 'required|exists:assessments,id',
            'answers' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'answers.required' => 'At least one question must be answered.',
            'answers.min' => 'At least one question must be answered.',
        ];
    }
}
