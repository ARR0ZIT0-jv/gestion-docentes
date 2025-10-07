<!DOCTYPE html>
<html>
<head>
    <title>Pagos - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Gestión de Pagos</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-4 mb-6">
            <a href="{{ route('pagos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                💰 Registrar Pago
            </a>
            <a href="{{ route('pagos.reporte-general') }}" class="bg-green-500 text-white px-4 py-2 rounded">
                📊 Reporte General
            </a>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-blue-600">
                    ${{ number_format(App\Models\Pago::sum('monto'), 2) }}
                </div>
                <div class="text-gray-600">Total Recaudado</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-green-600">
                    {{ App\Models\Pago::where('verificado', true)->count() }}
                </div>
                <div class="text-gray-600">Pagos Verificados</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-yellow-600">
                    {{ App\Models\Pago::where('verificado', false)->count() }}
                </div>
                <div class="text-gray-600">Pagos Pendientes</div>
            </div>
        </div>

        <!-- Tabla de pagos -->
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Docente</th>
                        <th class="px-4 py-2">Concepto</th>
                        <th class="px-4 py-2">Periodo</th>
                        <th class="px-4 py-2">Monto</th>
                        <th class="px-4 py-2">Fecha Pago</th>
                        <th class="px-4 py-2">Método</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            <a href="{{ route('pagos.reporte-docente', $pago->docente) }}" 
                               class="text-blue-600 hover:underline">
                                {{ $pago->docente->nombres }} {{ $pago->docente->apellidos }}
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $pago->concepto }}</td>
                        <td class="px-4 py-2">{{ $pago->periodo }}</td>
                        <td class="px-4 py-2 font-bold">${{ number_format($pago->monto, 2) }}</td>
                        <td class="px-4 py-2">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 capitalize">{{ $pago->metodo }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs {{ $pago->estado_clase }}">
                                {{ $pago->estado }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('pagos.show', $pago) }}" class="text-blue-600 mr-2">👁️</a>
                            <a href="{{ route('pagos.edit', $pago) }}" class="text-green-600 mr-2">✏️</a>
                            @if(!$pago->verificado)
                                <form action="{{ route('pagos.verificar', $pago) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 mr-2">✅</button>
                                </form>
                            @endif
                            <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('¿Eliminar pago?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>