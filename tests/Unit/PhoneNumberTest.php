<?php

namespace Tests\Unit;

use App\Support\PhoneNumber;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    #[DataProvider('numbers')]
    public function test_normalize(string $input, string $expected): void
    {
        $this->assertSame($expected, PhoneNumber::normalize($input));
    }

    public static function numbers(): array
    {
        return [
            'awalan 0' => ['081234567890', '6281234567890'],
            'dengan strip' => ['0812-3456-7890', '6281234567890'],
            'dengan +62' => ['+62 812 3456 7890', '6281234567890'],
            'sudah 62' => ['6281234567890', '6281234567890'],
            'tanpa 0' => ['81234567890', '6281234567890'],
            '+62 salah ketik 0' => ['+62 0812 3456 7890', '6281234567890'],
            'bukan angka' => ['abc', ''],
            'kosong' => ['', ''],
        ];
    }
}
