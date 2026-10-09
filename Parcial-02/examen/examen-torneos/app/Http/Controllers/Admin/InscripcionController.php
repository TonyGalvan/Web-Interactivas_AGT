<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Torneo;
use App\Models\User;

class InscripcionController extends Controller
{
    public function index(Torneo $torneo)
    {
        $torneo->loadCount('jugadores');
        $torneo->load(['jugadores' => fn($q) => $q->orderByPivot('created_at')]);

        return view('admin.torneos.inscripciones', compact('torneo'));
    }

    public function destroy(Torneo $torneo, User $user)
    {
        $quitados = $torneo->jugadores()->detach($user->id);

        if (! $quitados) {
            return back()->with('error', 'Ese jugador no está inscrito en este torneo.');
        }

        return back()->with('success', "Se dio de baja a {$user->name} del torneo.");
    }
}
