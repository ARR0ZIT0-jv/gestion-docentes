<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Docente;
use App\Models\Evento;
use App\Models\CargoUniversitario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
   
    // Listar todos los documentos
    public function index()
    {
        $documentos = Documento::with(['docente', 'evento', 'cargoUniversitario'])
                             ->orderBy('created_at', 'desc')
                             ->get();

        return view('documentos.index', compact('documentos'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        $docentes = Docente::where('activo', true)->get();
        $eventos = Evento::where('estado', '!=', 'cancelado')->get();
        $cargos = CargoUniversitario::where('activo', true)->get();

        return view('documentos.create', compact('docentes', 'eventos', 'cargos'));
    }

    // Guardar nuevo documento
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:acta,informe,estatuto,minuta,resolucion,otros',
            'archivo' => 'required|file|max:10240', // 10MB máximo
            'docente_id' => 'required|exists:docentes,id',
            'evento_id' => 'nullable|exists:eventos,id',
            'cargo_id' => 'nullable|exists:cargos_universitarios,id',
        ]);

        // Procesar el archivo
        $archivo = $request->file('archivo');
        $nombreOriginal = $archivo->getClientOriginalName();
        $extension = $archivo->getClientOriginalExtension();
        $tamanio = $archivo->getSize();

        // Generar nombre único para el archivo
        $nombreArchivo = time() . '_' . uniqid() . '.' . $extension;
        $rutaArchivo = $archivo->storeAs('documentos', $nombreArchivo, 'public');

        // Crear el documento
        Documento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'nombre_archivo' => $nombreOriginal,
            'ruta_archivo' => $rutaArchivo,
            'extension' => $extension,
            'tamanio' => $tamanio,
            'tipo' => $request->tipo,
            'docente_id' => $request->docente_id,
            'evento_id' => $request->evento_id,
            'cargo_id' => $request->cargo_id,
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento subido correctamente');
    }

    // Mostrar un documento
    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    // Descargar documento
    public function download(Documento $documento)
    {
        // Incrementar contador de descargas si lo deseas
        return Storage::disk('public')->download($documento->ruta_archivo, $documento->nombre_archivo);
    }

    // Eliminar documento
    public function destroy(Documento $documento)
    {
        // Eliminar archivo físico
        Storage::disk('public')->delete($documento->ruta_archivo);
        
        // Eliminar registro de la base de datos
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente');
    }

    // Ver documentos por tipo
    public function porTipo($tipo)
    {
        $documentos = Documento::with(['docente', 'evento', 'cargoUniversitario'])
                             ->where('tipo', $tipo)
                             ->orderBy('created_at', 'desc')
                             ->get();

        $tipos = [
            'acta' => 'Actas',
            'informe' => 'Informes',
            'estatuto' => 'Estatutos',
            'minuta' => 'Minutas',
            'resolucion' => 'Resoluciones',
            'otros' => 'Otros Documentos'
        ];

        $tipoNombre = $tipos[$tipo] ?? 'Documentos';

        return view('documentos.por-tipo', compact('documentos', 'tipo', 'tipoNombre'));
    }
}