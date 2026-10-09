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
        $ana = User::factory()->create([
            'name' => 'Ana',
            'email' => 'ana@example.com',
        ]);

        $luis = User::factory()->create([
            'name' => 'Luis',
            'email' => 'luis@example.com',
        ]);

        $ana->recetas()->create([
            'titulo' => 'Hot cakes caseros',
            'categoria' => 'desayuno',
            'tiempo_minutos' => 20,
            'dificultad' => 'fácil',
            'ingredientes' => "1 taza de harina\n1 huevo\n1 taza de leche\n1 cucharada de azúcar",
            'pasos' => "Mezclar los ingredientes secos\nAgregar el huevo y la leche\nCocinar en sartén caliente",
        ]);

        $ana->recetas()->create([
            'titulo' => 'Pastel de chocolate',
            'categoria' => 'postre',
            'tiempo_minutos' => 60,
            'dificultad' => 'media',
            'ingredientes' => "2 tazas de harina\n1 taza de cacao\n3 huevos\n1 taza de azúcar",
            'pasos' => "Precalentar el horno\nMezclar todo\nHornear 40 minutos",
            'nota' => 'Queda mejor con café en la mezcla.',
        ]);

        $luis->recetas()->create([
            'titulo' => 'Agua de jamaica',
            'categoria' => 'bebida',
            'tiempo_minutos' => 15,
            'dificultad' => 'fácil',
            'ingredientes' => "1 taza de flor de jamaica\n2 litros de agua\nAzúcar al gusto",
            'pasos' => "Hervir la jamaica\nColar\nEndulzar y enfriar",
        ]);
    }
}
