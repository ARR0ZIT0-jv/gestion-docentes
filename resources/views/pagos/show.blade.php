<!DOCTYPE html>
<html>
<head>
    <title>Pago #{{ $pago->id }} - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Detalles del Pago #{{ $pago->id }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('pagos.edit', $pago) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">✏️ Editar</a>
                <a href="{{ route('pagos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">📋 Lista de Pagos</a>
            </div>
        </div>

        <!-- Información del Pago -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold mb-4">Información del Pago</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Docente:</strong> 
                    <a href="{{ route('pagos.reporte-docente', $pago->docente) }}" class="text-blue-600 hover:underline">
                        {{ $pago->docente->nombres }} {{ $pago->docente->apellidos }}
                    </a>
                </div>
                <div><strong>Departamento:</strong> {{ $pago->docente->departamento }}</div>
                <div><strong>Monto:</strong> <span class="font-bold text-green-600">${{ number_format($pago->monto, 2) }}</span></div>
                <div><strong>Concepto:</strong> {{ $pago->concepto }}</div>
                <div><strong>Periodo:</strong> {{ $pago->periodo }}</div>
                <div><strong>Fecha de Pago:</strong> {{ $pago->fecha_pago->format('d/m/Y') }}</div>
                <div><strong>Método:</strong> <span class="capitalize">{{ $pago->metodo }}</span></div>
                <div><strong>Comprobante:</strong> {{ $pago->comprobante ?? 'No especificado' }}</div>
                <div><strong>Estado:</strong> 
                    <span class="px-2 py-1 rounded text-xs {{ $pago->verificado ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $pago->verificado ? '✅ Verificado' : '⏳ Pendiente' }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <strong>Observaciones:</strong> 
                    <p class="mt-1 text-gray-700">{{ $pago->observaciones ?? 'Sin observaciones' }}</p>
                </div>
                <div><strong>Registrado el:</strong> {{ $pago->created_at->format('d/m/Y H:i') }}</div>
                <div><strong>Última actualización:</strong> {{ $pago->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Acciones</h2>
            <div class="flex flex-wrap gap-4">
                @if(!$pago->verificado)
                    <form action="{{ route('pagos.verificar', $pago) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                            ✅ Verificar Pago
                        </button>
                    </form>
                @else
                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded">✅ Pago ya verificado</span>
                @endif
                
                <a href="{{ route('pagos.reporte-docente', $pago->docente) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    📊 Ver todos los pagos de este docente
                </a>
                
                <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded"
                            onclick="return confirm('¿Estás seguro de eliminar este pago? Esta acción no se puede deshacer.')">
                        🗑️ Eliminar Pago
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>