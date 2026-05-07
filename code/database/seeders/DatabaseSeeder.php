<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (App::isLocal()) {
            Log::info('Local env detected. Run seeders..');

            // users
            User::firstOrCreate(
                ['id' => 1],
                [
                    'name' => 'Anna K',
                    'email' => 'anna_k@gmail.com',
                    'password' => Hash::make('pwd123'),
                ]
            );

            User::firstOrCreate(
                ['id' => 2],
                [
                    'name' => 'John S',
                    'email' => 'john@gmail.com',
                    'password' => Hash::make('pwd123'),
                ]
            );

            // rooms
            Room::firstOrCreate(
                ['id' => 1],
                [
                    'room_number' => '1'
                ]
            );

            Room::firstOrCreate(
                ['id' => 2],
                [
                    'room_number' => '2B'
                ]
            );

            // room time slots
            $this->seedSlots(1, [
                ['start_time' => '08:00', 'end_time' => '09:00'],
                ['start_time' => '09:00', 'end_time' => '10:00'],
                ['start_time' => '10:00', 'end_time' => '11:00'],
                ['start_time' => '11:00', 'end_time' => '12:00'],
                ['start_time' => '12:00', 'end_time' => '13:00'],
                ['start_time' => '13:00', 'end_time' => '14:00'],
                ['start_time' => '14:00', 'end_time' => '15:00'],
                ['start_time' => '15:00', 'end_time' => '16:00'],
                ['start_time' => '16:00', 'end_time' => '17:00'],
                ['start_time' => '17:00', 'end_time' => '18:00'],
            ]);

            $this->seedSlots(2, [
                ['start_time' => '20:00', 'end_time' => '20:45'],
                ['start_time' => '21:00', 'end_time' => '21:45'],
                ['start_time' => '22:00', 'end_time' => '22:45']
            ]);
        }
    }

    private function seedSlots(int $roomId, array $timeSlots)
    {
        $room = Room::find($roomId);

        if ($room->timeSlots()->exists()) {
            return;
        }

        $room->timeSlots()->createMany($timeSlots);
    }
}
