<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipantTypeCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:participant_types,name',

            'event_id' => 'required|numeric',
            'url' => 'required|file',
            'template_width' => 'nullable|numeric',
            'template_height' => 'nullable|numeric'
        ];




        // $rules = [
        //     'event_id' => 'required|numeric',
        //     'url' => 'required|file',
        //     'template_width' => 'nullable|numeric',
        //     'template_height' => 'nullable|numeric'
        // ];
        // 
        // if ($this->getMethod() == "PUT") {
        //     $rules += [
        //         'name' => [
        //             'required',
        //             'string',
        //             'max:255',
        //             Rule::unique('participant_types')->ignore($this->ParticipantType),
        //         ],
        //     ];
        // }
        // return $rules;
    }
}
