<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TorneoRequest;
use App\Models\Torneo;

class TorneoController extends Controller
{
    public function index()
    {
        $torneos = Torneo::withCount('jugadores')->orderBy('fecha')->get();

        return view('admin.torneos.index', compact('torneos'));
    }

    public function create()
    {
        $torneo = new Torneo(['cupo' => 16, 'abierto' => true]);

        return view('admin.torneos.create', compact('torneo'));
    }

    public function store(TorneoRequest $request)
    {
        Torneo::create($request->validated());

        return redirect()->route('admin.torneos.index')
            ->with('success', 'Torneo creado correctamente.');
    }

    public function edit(Torneo $torneo)
    {
        return view('admin.torneos.edit', compact('torneo'));
    }

    public function update(TorneoRequest $request, Torneo $torneo)
    {
        $torneo->update($request->validated());

        return redirect()->route('admin.torneos.index')
            ->with('success', 'Torneo actualizado correctamente.');
    }

    public function destroy(Torneo $torneo)
    {
        $torneo->delete();

        return redirect()->route('admin.torneos.index')
            ->with('success', 'Torneo eliminado correctamente.');
    }
}
