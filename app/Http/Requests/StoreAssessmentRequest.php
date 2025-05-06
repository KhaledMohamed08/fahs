<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
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
            'questions' => 'required|array|min:1',

            'questions.*.title' => 'required|string|max:1000',
            'questions.*.score' => 'required|integer|min:10',
            'questions.*.type' => 'required|in:free_text,true_false,multiple_choice',

            // Free text
            'questions.*.text_answer_model' => 'nullable|string',

            // True/False
            'questions.*.is_true' => 'required_if:questions.*.type,true_false|boolean',

            // Multiple choice
            'questions.*.options' => 'required_if:questions.*.type,multiple_choice|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct' => 'required_if:questions.*.type,multiple_choice|integer|min:0',
        ];
    }
}
