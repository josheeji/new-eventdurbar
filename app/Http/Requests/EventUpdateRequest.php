<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventUpdateRequest extends FormRequest
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
        if ($this->getMethod() == "PUT") {
            $rules = [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // add any additional validation rules for the image field

                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('events')->ignore($this->id),
                ],
            ];
        }


        return $rules;

        // return [
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // add any additional validation rules for the image field

        //     'name' => [
        //         'required',
        //         'string',
        //         'max:255',
        //         Rule::unique('events')->ignore($this->event),
        //     ],
        // ];
    }




    //     return [

    //         'name' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'short_description' => 'nullable|string|max:255',

}
