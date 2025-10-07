<?php

namespace App\Http\Controllers;

use App\Models\Directiva;
use App\Models\Docente;
use Illuminate\Http\Request;

class DirectivaController extends Controller
{
    // Listar miembros de la directiva
    public function index()
    {
        $directiva = Directiva::with('docente')
                            ->where('vigente', true)
                            ->orderBy('cargo')
                            ->get();
        
        $historial = Directiva::with('docente')
                            ->where('vigente', false)
                            ->orderBy('fecha_fin', 'desc')
                            ->get();

        return view('directiva.index', compact('directiva', 'historial'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        $docentes = Docente::where('activo', true)->get();
        return view('directiva.create', compact('docentes'));
    }

    // Guardar nuevo miembro de directiva
    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'cargo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        // Desactivar cualquier cargo previo del docente
        Directiva::where('docente_id', $request->docente_id)
                ->update(['vigente' => false]);

        Directiva::create([
            'docente_id' => $request->docente_id,
            'cargo' => $request->cargo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'vigente' => true,
        ]);

        return redirect()->route('directiva.index')->with('success', 'Miembro agregado a la directiva correctamente');
    }

    // Mostrar detalles de un cargo
    public function show(Directiva $directiva)
    {
        return view('directiva.show', compact('directiva'));
    }

    // Mostrar formulario de editar
    public function edit(Directiva $directiva)
    {
        $docentes = Docente::where('activo', true)->get();
        return view('directiva.edit', compact('directiva', 'docentes'));
    }

    // Actualizar miembro de directiva
    public function update(Request $request, Directiva $directiva)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'cargo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'vigente' => 'required|boolean',
        ]);

        $directiva->update($request->all());

        return redirect()->route('directiva.index')->with('success', 'Información de directiva actualizada correctamente');
    }

    // Eliminar miembro de directiva
    public function destroy(Directiva $directiva)
    {
        $directiva->delete();
        return redirect()->route('directiva.index')->with('success', 'Miembro eliminado de la directiva correctamente');
    }

    // Finalizar cargo (hacer histórico)
    public function finalizar(Directiva $directiva)
    {
        $directiva->update(['vigente' => false]);
        return back()->with('success', 'Cargo finalizado correctamente');
    }
}