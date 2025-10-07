<!DOCTYPE html>
<html>
<head>
    <title>Directiva - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">🏛️ Directiva de la Asociación</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(Auth::user()->rol === 'administrador')
        <a href="{{ route('directiva.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            ➕ Agregar Miembro a Directiva
        </a>
        @endif

        <!-- Directiva Actual -->
        <div class="bg-white rounded shadow mb-6">
            <div class="bg-blue-600 text-white px-4 py-3">
                <h2 class="text-xl font-bold">Directiva Actual</h2>
                <p class="text-blue-100">Período en funciones</p>
            </div>
            
            @if($directiva->count() > 0)
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($directiva as $miembro)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="font-bold text-lg text-blue-700">{{ $miembro->cargo }}</h3>
                                    <p class="text-gray-600">{{ $miembro->docente->nombres }} {{ $miembro->docente->apellidos }}</p>
                                    <p class="text-sm text-gray-500">{{ $miembro->docente->departamento }}</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Activo</span>
                            </div>
                            
                            @if($miembro->descripcion)
                                <p class="text-sm text-gray-700 mb-2">{{ $miembro->descripcion }}</p>
                            @endif
                            
                            <div class="text-xs text-gray-500 border-t pt-2">
                                <div>Período: {{ $miembro->fecha_inicio->format('d/m/Y') }} - {{ $miembro->fecha_fin->format('d/m/Y') }}</div>
                            </div>

                            @if(Auth::user()->rol === 'administrador')
                            <div class="mt-3 flex space-x-2">
                                <a href="{{ route('directiva.edit', $miembro) }}" class="text-blue-600 text-sm">✏️ Editar</a>
                                <form action="{{ route('directiva.finalizar', $miembro) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 text-sm" 
                                            onclick="return confirm('¿Finalizar este cargo?')">⏸️ Finalizar</button>
                                </form>
                                <form action="{{ route('directiva.destroy', $miembro) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm"
                                            onclick="return confirm('¿Eliminar de la directiva?')">🗑️ Eliminar</button>
                                </form>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">No hay miembros activos en la directiva.</p>
                    @if(Auth::user()->rol === 'administrador')
                    <a href="{{ route('directiva.create') }}" class="text-blue-600 hover:underline">Agregar el primer miembro</a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Historial de Directiva -->
        <div class="bg-white rounded shadow">
            <div class="bg-gray-600 text-white px-4 py-3">
                <h2 class="text-xl font-bold">Historial de Directiva</h2>
                <p class="text-gray-300">Miembros anteriores</p>
            </div>
            
            @if($historial->count() > 0)
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Cargo</th>
                                    <th class="px-4 py-2">Docente</th>
                                    <th class="px-4 py-2">Período</th>
                                    <th class="px-4 py-2">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historial as $miembro)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $miembro->cargo }}</td>
                                    <td class="px-4 py-2">
                                        {{ $miembro->docente->nombres }} {{ $miembro->docente->apellidos }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $miembro->fecha_inicio->format('d/m/Y') }} - {{ $miembro->fecha_fin->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Histórico</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p>No hay historial de directiva disponible.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>