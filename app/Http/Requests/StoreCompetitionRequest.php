<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isManager();
    }

    public function rules(): array
    {
        return [
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:end_date',
            'status' => 'required|in:draft,active,closed,cancelled',
            'allowed_talents' => 'required|array|min:1',
            'allowed_talents.*' => 'exists:talents,id',
            'max_participants' => 'nullable|integer|min:1',
            'evaluation_criteria' => 'nullable|string',
        ];
    }
}
