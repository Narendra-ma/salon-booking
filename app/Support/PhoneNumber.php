<?php

namespace App\Support;

class PhoneNumber
{
    // Ubah input bebas ("0812-3456-7890", "+62 812 3456 7890", "812...") ke format 62812...
    public static function normalize(?string $input): string
    {
        $digits = preg_replace('/\D+/', '', (string) $input);

        return match (true) {
            // "+62 0812..." adalah salah ketik yang umum
            str_starts_with($digits, '620') => '62'.substr($digits, 3),
            str_starts_with($digits, '62') => $digits,
            str_starts_with($digits, '0') => '62'.substr($digits, 1),
            str_starts_with($digits, '8') => '62'.$digits,
            default => $digits,
        };
    }
}
