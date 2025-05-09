<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InscripcionEvento; // Asegúrate de tener esto arriba

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = \App\Models\Evento::all();
        return view('inicio', compact('eventos'));


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

    public function misCursos()
    {
    // Obtener todos los eventos a los que el usuario está inscrito
    $misEventos = auth()->user()->eventos()->with('archivos')->get();

    return view('eventos.mis_cursos', compact('misEventos'));
    }

    public function inscribirse(Evento $evento)
    {
         // Lógica para inscribir al alumno (relacionar evento y usuario)
            $evento->users()->attach(auth()->id());

    // Opcional: enviar correo, etc.

    // Redirigir con mensaje
            return redirect()->route('eventos.inicio')->with('message', '¡Te has inscrito exitosamente!');
    
    }


}
