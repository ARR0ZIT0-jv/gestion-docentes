<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Docente;
use Illuminate\Http\Request;

class PagoController extends Controller
{
   

    // Listar todos los pagos
    public function index()
    {
        $pagos = Pago::with('docente')
                    ->orderBy('fecha_pago', 'desc')
                    ->get();
        return view('pagos.index', compact('pagos'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        $docentes = Docente::where('activo', true)->get();
        return view('pagos.create', compact('docentes'));
    }

    // Guardar nuevo pago
    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'monto' => 'required|numeric|min:0',
            'concepto' => 'required|string|max:255',
            'periodo' => 'required|string|max:50',
            'fecha_pago' => 'required|date',
            'metodo' => 'required|in:efectivo,transferencia,tarjeta,otros',
            'comprobante' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        Pago::create($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente');
    }

    // Mostrar un pago
    public function show(Pago $pago)
    {
        return view('pagos.show', compact('pago'));
    }

    // Mostrar formulario de editar
    public function edit(Pago $pago)
    {
        $docentes = Docente::where('activo', true)->get();
        return view('pagos.edit', compact('pago', 'docentes'));
    }

    // Actualizar pago
    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'monto' => 'required|numeric|min:0',
            'concepto' => 'required|string|max:255',
            'periodo' => 'required|string|max:50',
            'fecha_pago' => 'required|date',
            'metodo' => 'required|in:efectivo,transferencia,tarjeta,otros',
            'comprobante' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        $pago->update($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente');
    }

    // Eliminar pago
    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente');
    }

    // Verificar pago
    public function verificar(Pago $pago)
    {
        $pago->update(['verificado' => true]);
        return back()->with('success', 'Pago verificado correctamente');
    }

    // Reporte de pagos por docente
    // Reporte de pagos por docente
public function reporteDocente(Docente $docente)
{
    $pagos = $docente->pagos()->orderBy('fecha_pago', 'desc')->get();
    return view('pagos.reporte-docente', compact('docente', 'pagos'));
}

// Reporte general de pagos
public function reporteGeneral()
{
    $pagos = Pago::with('docente')
                ->orderBy('fecha_pago', 'desc')
                ->get();
    
    $totalRecaudado = Pago::sum('monto');
    $pagosVerificados = Pago::where('verificado', true)->count();
    
    return view('pagos.reporte-general', compact('pagos', 'totalRecaudado', 'pagosVerificados'));
}
}