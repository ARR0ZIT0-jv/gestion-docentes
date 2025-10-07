<?php

namespace App\Http\Controllers;

use App\Models\CargoUniversitario;
use App\Models\Docente;
use Illuminate\Http\Request;

class CargoUniversitarioController extends Controller
{
    
    // Listar todos los cargos universitarios
    public function index()
    {
        $cargos = CargoUniversitario::with('docente')
                                  ->where('activo', true)
                                  ->orderBy('organo')
                                  ->orderBy('cargo')
                                  ->get();
        
        $historial = CargoUniversitario::with('docente')
                                     ->where('activo', false)
                                     ->orderBy('periodo', 'desc')
                                     ->get();

        return view('cargos-universitarios.index', compact('cargos', 'historial'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        $docentes = Docente::where('activo', true)->get();
        return view('cargos-universitarios.create', compact('docentes'));
    }

    // Guardar nuevo cargo universitario
    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'organo' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'periodo' => 'required|string|max:50',
            'funciones' => 'nullable|string',
        ]);

        CargoUniversitario::create([
            'docente_id' => $request->docente_id,
            'organo' => $request->organo,
            'cargo' => $request->cargo,
            'periodo' => $request->periodo,
            'funciones' => $request->funciones,
            'activo' => true,
        ]);

        return redirect()->route('cargos-universitarios.index')->with('success', 'Cargo de representación registrado correctamente');
    }

    // Mostrar detalles de un cargo
    public function show(CargoUniversitario $cargoUniversitario)
    {
        return view('cargos-universitarios.show', compact('cargoUniversitario'));
    }

    // Mostrar formulario de editar
    public function edit(CargoUniversitario $cargoUniversitario)
    {
        $docentes = Docente::where('activo', true)->get();
        return view('cargos-universitarios.edit', compact('cargoUniversitario', 'docentes'));
    }

    // Actualizar cargo universitario
    public function update(Request $request, CargoUniversitario $cargoUniversitario)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'organo' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'periodo' => 'required|string|max:50',
            'funciones' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);

        $cargoUniversitario->update($request->all());

        return redirect()->route('cargos-universitarios.index')->with('success', 'Cargo de representación actualizado correctamente');
    }

    // Eliminar cargo universitario
    public function destroy(CargoUniversitario $cargoUniversitario)
    {
        $cargoUniversitario->delete();
        return redirect()->route('cargos-universitarios.index')->with('success', 'Cargo de representación eliminado correctamente');
    }

    // Desactivar cargo
    public function desactivar(CargoUniversitario $cargoUniversitario)
    {
        $cargoUniversitario->update(['activo' => false]);
        return back()->with('success', 'Cargo desactivado correctamente');
    }

    // Activar cargo
    public function activar(CargoUniversitario $cargoUniversitario)
    {
        $cargoUniversitario->update(['activo' => true]);
        return back()->with('success', 'Cargo activado correctamente');
    }
}