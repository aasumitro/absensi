<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApplyNewSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'absent_type_id' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'title' => 'required',
            'description' => 'required',
            'file' => 'required|file|mimes:pdf,jpg,png,jpeg'
        ];
    }
}
