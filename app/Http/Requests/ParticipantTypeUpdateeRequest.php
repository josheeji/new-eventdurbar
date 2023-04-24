<?php

namespace App\Http\Requests;

use App\Models\ParticipantType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipantTypeUpdateeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        return [

            'event_id' => 'required|numeric',
            'url' => 'required|file',
            'template_width' => 'nullable|numeric',
            'template_height' => 'nullable|numeric',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('participant_types')->ignore($this->id),
            ],
        ];
    }
}
