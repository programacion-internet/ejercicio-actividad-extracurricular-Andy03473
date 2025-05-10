<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\Evento::create([
        'nombre' => 'Conferencia de Tecnología',
        'descripcion' => 'Evento sobre las últimas tendencias tecnológicas.',
        'fecha' => now()->addDays(5),
    ]);

    \App\Models\Evento::create([
        'nombre' => 'Taller de Laravel',
        'descripcion' => 'Aprende a crear aplicaciones con Laravel.',
        'fecha' => now()->addDays(10),
    ]);

    \App\Models\Evento::create([
        'nombre' => 'Seminario de Redes',
        'descripcion' => 'Fundamentos y prácticas de redes informáticas.',
        'fecha' => now()->addDays(15),
    ]);

    \App\Models\Evento::create([
        'nombre' => 'Hackathon Universitario',
        'descripcion' => 'Competencia de programación intensiva.',
        'fecha' => now()->addDays(20),
    ]);

    \App\Models\Evento::create([
        'nombre' => 'Foro de Innovación',
        'descripcion' => 'Espacio para la innovación y creatividad.',
        'fecha' => now()->addDays(25),
    ]);
}

}
