<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventCreateRequest extends FormRequest
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
            'slug' => 'required|unique:events|max:255',

            'name' => 'required|string|max:255',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

            'image' => 'nullable|image|max:2048', // accepts image files up to 2MB
            // 'short_description' => 'nullable|string|max:255',


        ];
    }
}
