<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isStudent();
    }

    public function rules(): array
    {
        return [
            'competition_id' => 'required|exists:competitions,id',
            'talent_id' => 'required|exists:talents,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,mp4,mov,avi|max:20480',
        ];
    }
}
