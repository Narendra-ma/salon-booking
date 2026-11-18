<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('services', 'name')->ignore($this->route('service'))],
            'description' => ['nullable', 'string', 'max:500'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:480', 'multiple_of:15'],
            'price' => ['required', 'integer', 'min:0', 'max:10000000'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'duration_minutes.multiple_of' => 'Durasi harus kelipatan 15 menit.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama layanan',
            'description' => 'deskripsi',
            'duration_minutes' => 'durasi',
            'price' => 'harga',
        ];
    }
}
