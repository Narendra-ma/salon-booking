<?php

namespace App\Http\Requests;

use App\Services\BookingService;
use App\Support\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'customer_phone' => PhoneNumber::normalize($this->input('customer_phone')),
        ]);
    }

    public function rules(): array
    {
        $lastDate = now()->addDays(config('salon.max_advance_days'))->toDateString();

        return [
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'regex:/^628\d{8,12}$/'],
            'service_id' => ['required', Rule::exists('services', 'id')->where('is_active', true)],
            'booking_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:'.$lastDate],
            'start_time' => ['required', Rule::in(app(BookingService::class)->slots())],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_phone.regex' => 'Nomor WhatsApp tidak valid. Contoh: 0812-3456-7890.',
            'booking_date.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'booking_date.before_or_equal' => 'Booking hanya bisa untuk '.config('salon.max_advance_days').' hari ke depan.',
            'start_time.in' => 'Jam yang dipilih tidak tersedia.',
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_name' => 'nama',
            'customer_phone' => 'nomor WhatsApp',
            'service_id' => 'layanan',
            'booking_date' => 'tanggal',
            'start_time' => 'jam',
        ];
    }
}
