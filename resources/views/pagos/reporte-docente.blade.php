<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Pagos - {{ $docente->nombres }} {{ $docente->apellidos }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Reporte de Pagos</h1>
                <h2 class="text-xl text-gray-600">{{ $docente->nombres }} {{ $docente->apellidos }}</h2>
                <p class="text-gray-500">{{ $docente->departamento }} • {{ $docente->email }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('pagos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">📋 Todos los Pagos</a>
                <a href="{{ route('pagos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">💰 Nuevo Pago</a>
            </div>
        </div>

        <!-- Estadísticas del docente -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-green-600">
                    ${{ number_format($docente->pagos->sum('monto'), 2) }}
                </div>
                <div class="text-gray-600">Total Pagado</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-blue-600">
                    {{ $docente->pagos->count() }}
                </div>
                <div class="text-gray-600">Pagos Registrados</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-yellow-600">
                    {{ $docente->pagos->where('verificado', false)->count() }}
                </div>
                <div class="text-gray-600">Pagos Pendientes</div>
            </div>
        </div>

        <!-- Lista de pagos del docente -->
        <div class="bg-white rounded shadow overflow-hidden">
            <div class="bg-gray-200 px-4 py-3">
                <h3 class="font-bold">Historial de Pagos ({{ $pagos->count() }})</h3>
            </div>
            
            @if($pagos->count() > 0)
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Concepto</th>
                            <th class="px-4 py-2">Periodo</th>
                            <th class="px-4 py-2">Monto</th>
                            <th class="px-4 py-2">Fecha</th>
                            <th class="px-4 py-2">Método</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pagos as $pago)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $pago->id }}</td>
                            <td class="px-4 py-2">{{ $pago->concepto }}</td>
                            <td class="px-4 py-2">{{ $pago->periodo }}</td>
                            <td class="px-4 py-2 font-bold text-green-600">${{ number_format($pago->monto, 2) }}</td>
                            <td class="px-4 py-2">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 capitalize">{{ $pago->metodo }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs {{ $pago->verificado ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $pago->verificado ? 'Verificado' : 'Pendiente' }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('pagos.show', $pago) }}" class="text-blue-600 mr-2">👁️</a>
                                <a href="{{ route('pagos.edit', $pago) }}" class="text-green-600 mr-2">✏️</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">No se encontraron pagos para este docente.</p>
                    <a href="{{ route('pagos.create') }}" class="text-blue-600 hover:underline">Registrar primer pago</a>
                </div>
            @endif
        </div>

        <!-- Resumen por año -->
        @if($pagos->count() > 0)
        <div class="bg-white p-6 rounded shadow mt-6">
            <h3 class="text-lg font-bold mb-4">Resumen por Año</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $pagosPorAnio = $pagos->groupBy(function($pago) {
                        return $pago->fecha_pago->format('Y');
                    });
                @endphp
                
                @foreach($pagosPorAnio as $anio => $pagosAnio)
                <div class="border rounded p-3">
                    <div class="font-bold text-blue-600">{{ $anio }}</div>
                    <div class="text-2xl font-bold text-green-600">
                        ${{ number_format($pagosAnio->sum('monto'), 2) }}
                    </div>
                    <div class="text-sm text-gray-600">{{ $pagosAnio->count() }} pagos</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</body>
</html>