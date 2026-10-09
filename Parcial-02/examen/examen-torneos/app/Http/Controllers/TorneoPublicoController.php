<?php

namespace App\Http\Controllers;

use App\Models\Torneo;

class TorneoPublicoController extends Controller
{
    public function index()
    {
        $torneos = Torneo::disponibles()
            ->withCount('jugadores')
            ->orderBy('fecha')
            ->get();

        return view('torneos.index', compact('torneos'));
    }

    public function show(Torneo $torneo)
    {
        $torneo->loadCount('jugadores');
        $torneo->load(['jugadores' => fn($q) => $q->orderByPivot('created_at')]);

        return view('torneos.show', compact('torneo'));
    }
}
