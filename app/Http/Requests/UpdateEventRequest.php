<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->id === $this->event->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date', 'after:today'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Event title is required.',
            'title.max' => 'Event title cannot exceed 255 characters.',
            'date.required' => 'Event date is required.',
            'date.after' => 'Event date must be in the future.',
            'capacity.required' => 'Event capacity is required.',
            'capacity.min' => 'Event must have at least 1 seat.',
            'capacity.max' => 'Event capacity cannot exceed 10,000 seats.',
        ];
    }
}
