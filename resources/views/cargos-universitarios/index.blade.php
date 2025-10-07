<!DOCTYPE html>
<html>
<head>
    <title>Cargos Universitarios - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">🎓 Cargos de Representación Universitaria</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(Auth::user()->rol === 'administrador')
        <a href="{{ route('cargos-universitarios.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            ➕ Registrar Cargo Universitario
        </a>
        @endif

        <!-- Cargos Activos -->
        <div class="bg-white rounded shadow mb-6">
            <div class="bg-purple-600 text-white px-4 py-3">
                <h2 class="text-xl font-bold">Cargos Activos</h2>
                <p class="text-purple-100">Representación universitaria actual</p>
            </div>
            
            @if($cargos->count() > 0)
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Órgano Universitario</th>
                                    <th class="px-4 py-2">Cargo</th>
                                    <th class="px-4 py-2">Docente</th>
                                    <th class="px-4 py-2">Departamento</th>
                                    <th class="px-4 py-2">Periodo</th>
                                    @if(Auth::user()->rol === 'administrador')
                                    <th class="px-4 py-2">Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cargos as $cargo)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 font-medium text-purple-700">{{ $cargo->organo }}</td>
                                    <td class="px-4 py-2">{{ $cargo->cargo }}</td>
                                    <td class="px-4 py-2">
                                        {{ $cargo->docente->nombres }} {{ $cargo->docente->apellidos }}
                                    </td>
                                    <td class="px-4 py-2">{{ $cargo->docente->departamento }}</td>
                                    <td class="px-4 py-2">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">{{ $cargo->periodo }}</span>
                                    </td>
                                    @if(Auth::user()->rol === 'administrador')
                                    <td class="px-4 py-2">
                                        <a href="{{ route('cargos-universitarios.show', $cargo) }}" class="text-blue-600 mr-2">👁️</a>
                                        <a href="{{ route('cargos-universitarios.edit', $cargo) }}" class="text-green-600 mr-2">✏️</a>
                                        <form action="{{ route('cargos-universitarios.desactivar', $cargo) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 mr-2" 
                                                    onclick="return confirm('¿Desactivar este cargo?')">⏸️</button>
                                        </form>
                                        <form action="{{ route('cargos-universitarios.destroy', $cargo) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600"
                                                    onclick="return confirm('¿Eliminar este cargo?')">🗑️</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">No hay cargos universitarios activos registrados.</p>
                    @if(Auth::user()->rol === 'administrador')
                    <a href="{{ route('cargos-universitarios.create') }}" class="text-blue-600 hover:underline">Registrar el primer cargo</a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Historial de Cargos -->
        <div class="bg-white rounded shadow">
            <div class="bg-gray-600 text-white px-4 py-3">
                <h2 class="text-xl font-bold">Historial de Cargos</h2>
                <p class="text-gray-300">Cargos anteriores</p>
            </div>
            
            @if($historial->count() > 0)
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Órgano</th>
                                    <th class="px-4 py-2">Cargo</th>
                                    <th class="px-4 py-2">Docente</th>
                                    <th class="px-4 py-2">Periodo</th>
                                    @if(Auth::user()->rol === 'administrador')
                                    <th class="px-4 py-2">Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historial as $cargo)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $cargo->organo }}</td>
                                    <td class="px-4 py-2">{{ $cargo->cargo }}</td>
                                    <td class="px-4 py-2">
                                        {{ $cargo->docente->nombres }} {{ $cargo->docente->apellidos }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $cargo->periodo }}</span>
                                    </td>
                                    @if(Auth::user()->rol === 'administrador')
                                    <td class="px-4 py-2">
                                        <form action="{{ route('cargos-universitarios.activar', $cargo) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 mr-2">▶️</button>
                                        </form>
                                        <form action="{{ route('cargos-universitarios.destroy', $cargo) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600"
                                                    onclick="return confirm('¿Eliminar este cargo?')">🗑️</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p>No hay historial de cargos universitarios.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>