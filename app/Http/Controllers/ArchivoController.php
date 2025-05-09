<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ArchivoController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'archivo' => 'required|file|max:2048',
        ]);

        // Buscar el evento solicitado
        $evento = Evento::findOrFail($request->evento_id);

        // Verificar si el usuario está inscrito en el evento
        if (!Auth::user()->eventos()->where('eventos.id', $evento->id)->exists()) {
            return back()->with('error', 'No puedes subir archivos a eventos en los que no estás inscrito.');
        }

        // Almacenar el archivo en la carpeta 'archivos'
        $path = $request->file('archivo')->store('archivos');

        // Guardar el registro en la base de datos
        Archivo::create([
            'user_id' => Auth::id(),
            'evento_id' => $evento->id,
            'nombre' => $request->file('archivo')->getClientOriginalName(),
            'ruta' => $path,
        ]);

        // Retornar con mensaje de éxito
        return back()->with('success', 'Archivo subido correctamente.');
    }

    public function destroy(Archivo $archivo)
    {
        // Verifica permisos de autorización antes de eliminar
        $this->autorize('delete', $archivo);

        // Eliminar el archivo físico
        Storage::delete($archivo->ruta);

        // Eliminar el registro en la base de datos
        $archivo->delete();

        return back()->with('success', 'Archivo eliminado correctamente.');
    }
}
