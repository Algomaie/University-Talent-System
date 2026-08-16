<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isManager();
    }

    public function rules(): array
    {
        return [
            'creativity_score' => 'required|integer|min:1|max:10',
            'technical_score' => 'required|integer|min:1|max:10',
            'presentation_score' => 'required|integer|min:1|max:10',
            'comments' => 'required|string',
            'is_nominated' => 'boolean',
            'nomination_reason' => 'nullable|required_if:is_nominated,1|string',
        ];
    }
}
