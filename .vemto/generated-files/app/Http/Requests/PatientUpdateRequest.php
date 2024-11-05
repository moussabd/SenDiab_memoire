<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'matricule' => [
                'required',
                'string',
                Rule::unique('patient', 'matricule')->ignore($this->patient),
            ],
            'medical_histroy' => ['nullable'],
            'user_id' => ['required'],
            'deleted_at' => ['nullable', 'date'],
        ];
    }
}
