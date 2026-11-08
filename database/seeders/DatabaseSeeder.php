<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Client;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => 'password',
            'is_admin' => false,
        ]);

        User::firstOrCreate(['email' => 'admin@barbershop.test'], [
            'name' => 'Shop Admin',
            'username' => 'admin',
            'password' => 'password',
            'is_admin' => true,
        ]);

        $cuts = ServiceCategory::firstOrCreate(['name' => 'Haircuts']);
        $grooming = ServiceCategory::firstOrCreate(['name' => 'Grooming']);
        $extras = ServiceCategory::firstOrCreate(['name' => 'Extras']);

        $haircut = Service::firstOrCreate(
            ['name' => 'Classic Haircut'],
            [
                'service_category_id' => $cuts->id,
                'price' => 150.00,
                'duration_minutes' => 30,
            ]
        );
        $fade = Service::firstOrCreate(
            ['name' => 'Skin Fade'],
            [
                'service_category_id' => $cuts->id,
                'price' => 200.00,
                'duration_minutes' => 40,
            ]
        );
        $beard = Service::firstOrCreate(
            ['name' => 'Beard Trim'],
            [
                'service_category_id' => $grooming->id,
                'price' => 80.00,
                'duration_minutes' => 20,
            ]
        );
        Service::firstOrCreate(
            ['name' => 'Hair Wash'],
            [
                'service_category_id' => $extras->id,
                'price' => 50.00,
                'duration_minutes' => 15,
            ]
        );

        $barber1 = Barber::firstOrCreate(['email' => 'marco@barbershop.test'], [
            'name' => 'Marco Reyes',
            'phone' => '09171234567',
            'specialty' => 'Fades & pompadours',
        ]);
        $barber2 = Barber::firstOrCreate(['email' => 'juno@barbershop.test'], [
            'name' => 'Juno Cruz',
            'phone' => '09187654321',
            'specialty' => 'Classic cuts & beard sculpting',
        ]);

        $client1 = Client::firstOrCreate(['email' => 'alex@example.com'], [
            'name' => 'Alex Santos',
            'phone' => '09991112222',
        ]);
        $client2 = Client::firstOrCreate(['email' => 'ben@example.com'], [
            'name' => 'Ben Dela Cruz',
            'phone' => '09993334444',
        ]);

        Appointment::firstOrCreate(
            [
                'client_id' => $client1->id,
                'barber_id' => $barber1->id,
                'service_id' => $haircut->id,
                'appointment_date' => now()->addDay()->toDateString(),
                'appointment_time' => '10:00',
            ],
            ['status' => 'confirmed']
        );

        Appointment::firstOrCreate(
            [
                'client_id' => $client2->id,
                'barber_id' => $barber2->id,
                'service_id' => $fade->id,
                'appointment_date' => now()->addDays(2)->toDateString(),
                'appointment_time' => '14:30',
            ],
            ['status' => 'pending']
        );

        Appointment::firstOrCreate(
            [
                'client_id' => $client1->id,
                'barber_id' => $barber2->id,
                'service_id' => $beard->id,
                'appointment_date' => now()->subDay()->toDateString(),
                'appointment_time' => '16:00',
            ],
            [
                'status' => 'completed',
                'notes' => 'Clean up sides, keep length on top.',
            ]
        );

        Appointment::firstOrCreate(
            [
                'client_id' => $client2->id,
                'barber_id' => $barber1->id,
                'service_id' => $haircut->id,
                'appointment_date' => now()->toDateString(),
                'appointment_time' => '11:00',
            ],
            [
                'status' => 'confirmed',
                'notes' => 'Usual classic cut.',
            ]
        );
    }
}
