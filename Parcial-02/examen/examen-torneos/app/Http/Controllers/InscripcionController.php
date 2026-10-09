<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function store(Request $request, Torneo $torneo)
    {
        $user = $request->user();

        if (! $user->esJugador()) {
            return back()->with('error', 'Solo los jugadores pueden inscribirse en un torneo.');
        }

        // Transacción con bloqueo para que dos jugadores no tomen la última plaza a la vez
        [$tipo, $mensaje] = DB::transaction(function () use ($torneo, $user) {
            $torneo = Torneo::lockForUpdate()->findOrFail($torneo->id);

            if ($torneo->jugadores()->where('users.id', $user->id)->exists()) {
                return ['error', 'Ya estás inscrito en este torneo.'];
            }
            if (! $torneo->abierto) {
                return ['error', 'Este torneo está cerrado.'];
            }
            if ($torneo->vencido()) {
                return ['error', 'Este torneo ya se realizó.'];
            }
            if ($torneo->lleno()) {
                return ['error', 'Este torneo ya no tiene plazas disponibles.'];
            }

            $torneo->jugadores()->attach($user->id);

            return ['success', 'Te inscribiste correctamente en el torneo.'];
        });

        return back()->with($tipo, $mensaje);
    }

    public function destroy(Request $request, Torneo $torneo)
    {
        if ($torneo->vencido()) {
            return back()->with('error', 'Ya no puedes cancelar: el torneo ya se realizó.');
        }

        $quitados = $torneo->jugadores()->detach($request->user()->id);

        if (! $quitados) {
            return back()->with('error', 'No estás inscrito en este torneo.');
        }

        return back()->with('success', 'Tu inscripción fue cancelada y la plaza quedó libre.');
    }

    public function index(Request $request)
    {
        if (! $request->user()->esJugador()) {
            return redirect()->route('dashboard')
                ->with('error', 'Solo los jugadores tienen la sección Mis torneos.');
        }

        $torneos = $request->user()->torneos()->orderBy('fecha')->get();

        return view('inscripciones.index', compact('torneos'));
    }
}
