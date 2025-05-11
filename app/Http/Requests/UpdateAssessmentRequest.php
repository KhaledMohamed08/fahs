<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssessmentRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'duration_minutes' => 'required|integer|min:0',
            'auto_grade' => 'nullable|boolean',
            'access' => 'nullable|in:public,private',
            'difficulty_level'=> 'nullable|integer|min:1',
            'passing_percent' => 'nullable|integer|min:0|max:100',
            'is_active' => 'nullable|boolean',
        ];
    }
}
