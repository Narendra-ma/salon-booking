<?php

return [
    'name' => env('SALON_NAME', 'Salon Cantik'),
    'tagline' => env('SALON_TAGLINE', ''),
    'address' => env('SALON_ADDRESS', ''),
    'phone' => env('SALON_PHONE', ''),
    'whatsapp' => env('SALON_WHATSAPP', ''),
    'instagram' => env('SALON_INSTAGRAM', ''),
    'open_text' => env('SALON_OPEN_TEXT', ''),
    'map_query' => env('SALON_MAP_QUERY', 'Surabaya'),

    'open' => env('SALON_OPEN', '09:00'),
    'close' => env('SALON_CLOSE', '20:00'),
    'slot_minutes' => (int) env('SALON_SLOT_MINUTES', 30),
    'max_advance_days' => (int) env('SALON_MAX_ADVANCE_DAYS', 30),

    'admin' => [
        'name' => env('ADMIN_NAME', 'Pemilik Salon'),
        'email' => env('ADMIN_EMAIL', 'admin@salon.test'),
        'password' => env('ADMIN_PASSWORD'),
    ],
];
