<!DOCTYPE html>
<html>
<head>
    <title>Reporte General de Pagos - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Reporte General de Pagos</h1>
            <div class="flex space-x-2">
                <a href="{{ route('pagos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">📋 Gestión de Pagos</a>
                <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded">🖨️ Imprimir</button>
            </div>
        </div>

        <!-- Estadísticas generales -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow text-center">
                <div class="text-2xl font-bold text-green-600">${{ number_format($totalRecaudado, 2) }}</div>
                <div class="text-gray-600">Total Recaudado</div>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $pagos->count() }}</div>
                <div class="text-gray-600">Total de Pagos</div>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <div class="text-2xl font-bold text-green-600">{{ $pagosVerificados }}</div>
                <div class="text-gray-600">Pagos Verificados</div>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $pagos->count() - $pagosVerificados }}</div>
                <div class="text-gray-600">Pagos Pendientes</div>
            </div>
        </div>

        <!-- Resumen por método de pago -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-xl font-bold mb-4">Resumen por Método de Pago</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $pagosPorMetodo = $pagos->groupBy('metodo');
                @endphp
                
                @foreach($pagosPorMetodo as $metodo => $pagosMetodo)
                <div class="border rounded p-3 text-center">
                    <div class="font-bold text-gray-600 capitalize">{{ $metodo }}</div>
                    <div class="text-2xl font-bold text-green-600">${{ number_format($pagosMetodo->sum('monto'), 2) }}</div>
                    <div class="text-sm text-gray-500">{{ $pagosMetodo->count() }} pagos</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Lista completa de pagos -->
        <div class="bg-white rounded shadow overflow-hidden">
            <div class="bg-gray-200 px-4 py-3">
                <h2 class="font-bold">Todos los Pagos Registrados ({{ $pagos->count() }})</h2>
            </div>
            
            @if($pagos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Docente</th>
                                <th class="px-4 py-2">Concepto</th>
                                <th class="px-4 py-2">Periodo</th>
                                <th class="px-4 py-2">Monto</th>
                                <th class="px-4 py-2">Fecha</th>
                                <th class="px-4 py-2">Método</th>
                                <th class="px-4 py-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagos as $pago)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $pago->id }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('pagos.reporte-docente', $pago->docente) }}" class="text-blue-600 hover:underline">
                                        {{ $pago->docente->nombres }} {{ $pago->docente->apellidos }}
                                    </a>
                                </td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">No se encontraron pagos registrados.</p>
                    <a href="{{ route('pagos.create') }}" class="text-blue-600 hover:underline">Registrar primer pago</a>
                </div>
            @endif
        </div>

        <!-- Resumen por meses -->
        @if($pagos->count() > 0)
        <div class="bg-white p-6 rounded shadow mt-6">
            <h2 class="text-xl font-bold mb-4">Resumen por Mes ({{ date('Y') }})</h2>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                @php
                    $meses = [
                        1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 
                        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
                        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
                    ];
                    
                    $pagosPorMes = $pagos->filter(function($pago) {
                        return $pago->fecha_pago->format('Y') == date('Y');
                    })->groupBy(function($pago) {
                        return $pago->fecha_pago->format('n');
                    });
                @endphp
                
                @foreach($meses as $numero => $nombre)
                @php
                    $pagosMes = $pagosPorMes[$numero] ?? collect([]);
                    $totalMes = $pagosMes->sum('monto');
                @endphp
                <div class="border rounded p-3 text-center">
                    <div class="font-bold text-gray-600">{{ $nombre }}</div>
                    <div class="text-lg font-bold {{ $totalMes > 0 ? 'text-green-600' : 'text-gray-400' }}">
                        ${{ number_format($totalMes, 2) }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $pagosMes->count() }} pagos</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</body>
</html>