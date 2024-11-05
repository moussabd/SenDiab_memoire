<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
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
                Rule::unique('doctor', 'matricule')->ignore($this->doctor),
            ],
            'speciality' => ['nullable', 'string'],
            'num_ordre' => [
                'required',
                'string',
                Rule::unique('doctor', 'num_ordre')->ignore($this->doctor),
            ],
            'user_id' => ['required'],
            'entity_id' => ['required'],
        ];
    }
}
