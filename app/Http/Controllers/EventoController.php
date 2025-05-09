<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::orderBy('fecha', 'asc')->get();
        return view('eventos.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('eventos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
        ]);

        // Guardamos el evento
        Evento::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('eventos.index')->with('success', '¡Evento creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        // Validamos los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
        ]);

        // Actualizamos el evento
        $evento->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('eventos.index')->with('success', '¡Evento actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
