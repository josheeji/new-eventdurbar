<?php

namespace App\Http\Requests;

use App\Models\Event;
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
        // $event = Event::all();
        return [
            // 'event_slug' => 'required|string|max:255|unique:events,event_slug',
            // 'event_slug' => 'required|string|max:255|unique:events,event_slug,'.$this->id.',id,deleted_at,NULL',

            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // accepts image files up to 2MB

            'event_slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('events')->where(function ($query) {
                    $query->whereNull('deleted_at')->orWhereNotNull('deleted_at');
                })->ignore($this->id)
            ],

        ];
    }
}
