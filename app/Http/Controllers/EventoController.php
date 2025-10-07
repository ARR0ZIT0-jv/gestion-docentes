<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Docente;
use App\Models\Asistencia;
use Illuminate\Http\Request;

class EventoController extends Controller
{
 
    // Listar todos los eventos
    public function index()
    {
        $eventos = Evento::orderBy('fecha_inicio', 'desc')->get();
        return view('eventos.index', compact('eventos'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        return view('eventos.create');
    }

    // Guardar nuevo evento
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'lugar' => 'nullable|string|max:255',
            'tipo' => 'required|in:reunion,seminario,taller,social,otros',
            'cupo_maximo' => 'nullable|integer|min:1',
        ]);

        Evento::create($request->all());

        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente');
    }

    // Mostrar un evento con asistentes
 public function show(Evento $evento)
{
    $docentes = Docente::where('activo', true)->get();
    $asistentes = $evento->docentes()->withPivot('confirmado', 'asistio')->get();
    
    return view('eventos.show', compact('evento', 'docentes', 'asistentes'));
}

// Mostrar formulario de edición
public function edit(Evento $evento)
{
    return view('eventos.edit', compact('evento'));
}

    // Actualizar evento
    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'lugar' => 'nullable|string|max:255',
            'tipo' => 'required|in:reunion,seminario,taller,social,otros',
            'cupo_maximo' => 'nullable|integer|min:1',
        ]);

        $evento->update($request->all());

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente');
    }

    // Eliminar evento
    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado correctamente');
    }

    // Inscribir docente a evento
    public function inscribir(Request $request, Evento $evento)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
        ]);

        // Verificar si ya está inscrito
        if ($evento->docentes()->where('docente_id', $request->docente_id)->exists()) {
            return back()->with('error', 'El docente ya está inscrito en este evento');
        }

        $evento->docentes()->attach($request->docente_id, [
            'confirmado' => true,
            'asistio' => false
        ]);

        return back()->with('success', 'Docente inscrito correctamente');
    }

    // Marcar asistencia
    public function marcarAsistencia(Request $request, Evento $evento)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'asistio' => 'required|boolean',
        ]);

        $evento->docentes()->updateExistingPivot($request->docente_id, [
            'asistio' => $request->asistio
        ]);

        return back()->with('success', 'Asistencia actualizada correctamente');
    }
    // Mostrar detalles del evento con gestión de inscripciones

}