<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use App\Http\Requests\RecetaRequest;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categorias = ['desayuno', 'almuerzo', 'cena', 'postre', 'bebida'];

        $buscar = $request->input('buscar');
        $categoria = $request->input('categoria');

        $recetas = auth()->user()->recetas()
            ->when($buscar, fn($query) => $query->where('titulo', 'like', "%{$buscar}%"))
            ->when($categoria, fn($query) => $query->where('categoria', $categoria))
            ->latest()
            ->get();

        return view('recetas.index', compact('recetas', 'categorias', 'buscar', 'categoria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recetas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecetaRequest $request)
    {
        $request->user()->recetas()->create($request->validated());

        return redirect()->route('recetas.index')
            ->with('exito', 'Receta creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Receta $receta)
    {
        $this->autorizar($receta);

        return view('recetas.show', compact('receta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receta $receta)
    {
        $this->autorizar($receta);

        return view('recetas.edit', compact('receta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecetaRequest $request, Receta $receta)
    {
        $this->autorizar($receta);

        $receta->update($request->validated());

        return redirect()->route('recetas.index')
            ->with('exito', 'Receta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receta $receta)
    {
        $this->autorizar($receta);

        $receta->delete();

        return redirect()->route('recetas.index')
            ->with('exito', 'Receta eliminada correctamente.');
    }

    private function autorizar(Receta $receta): void
    {
        abort_if($receta->user_id !== auth()->id(), 403);
    }
}
