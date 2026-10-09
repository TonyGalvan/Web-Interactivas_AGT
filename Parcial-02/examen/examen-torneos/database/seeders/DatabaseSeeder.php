<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@torneos.test',
            'password' => bcrypt('admin1234'),
            'role' => 'administrador',
        ]);

        User::factory()->create([
            'name' => 'Jugador Demo',
            'email' => 'jugador@torneos.test',
            'password' => bcrypt('jugador1234'),
            'role' => 'jugador',
        ]);
    }
}
