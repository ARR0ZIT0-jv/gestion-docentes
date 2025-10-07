<!DOCTYPE html>
<html>
<head>
    <title>Eventos - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Gestión de Eventos</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('eventos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            ➕ Nuevo Evento
        </a>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Título</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Lugar</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Inscritos</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventos as $evento)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $evento->titulo }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                {{ $evento->tipo }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-2">{{ $evento->lugar ?? 'Sin especificar' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 
                                @if($evento->estado == 'planificado') bg-yellow-100 text-yellow-800
                                @elseif($evento->estado == 'confirmado') bg-green-100 text-green-800
                                @elseif($evento->estado == 'finalizado') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800 @endif
                                rounded text-xs">
                                {{ $evento->estado }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            {{ $evento->docentes->count() }} 
                            @if($evento->cupo_maximo)
                                / {{ $evento->cupo_maximo }}
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('eventos.show', $evento) }}" class="text-blue-600 mr-2">👁️ Ver</a>
                            <a href="{{ route('eventos.edit', $evento) }}" class="text-green-600 mr-2">✏️ Editar</a>
                            <form action="{{ route('eventos.destroy', $evento) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('¿Eliminar evento?')">🗑️ Eliminar</button>
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