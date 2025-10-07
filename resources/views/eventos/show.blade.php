<!DOCTYPE html>
<html>
<head>
    <title>Evento: {{ $evento->titulo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Evento: {{ $evento->titulo }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('eventos.edit', $evento) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">✏️ Editar</a>
                <a href="{{ route('eventos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">← Volver</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Información del Evento -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold mb-4">Información del Evento</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Título:</strong> {{ $evento->titulo }}</div>
                <div><strong>Tipo:</strong> <span class="capitalize">{{ $evento->tipo }}</span></div>
                <div><strong>Estado:</strong> 
                    <span class="px-2 py-1 rounded text-xs 
                        @if($evento->estado == 'planificado') bg-yellow-100 text-yellow-800
                        @elseif($evento->estado == 'confirmado') bg-green-100 text-green-800
                        @elseif($evento->estado == 'finalizado') bg-gray-100 text-gray-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $evento->estado }}
                    </span>
                </div>
                <div><strong>Fecha Inicio:</strong> {{ $evento->fecha_inicio->format('d/m/Y H:i') }}</div>
                <div><strong>Fecha Fin:</strong> {{ $evento->fecha_fin->format('d/m/Y H:i') }}</div>
                <div><strong>Lugar:</strong> {{ $evento->lugar ?? 'No especificado' }}</div>
                <div><strong>Cupo:</strong> 
                    {{ $evento->docentes->count() }} 
                    @if($evento->cupo_maximo)
                        / {{ $evento->cupo_maximo }} inscritos
                    @else
                        inscritos (cupo ilimitado)
                    @endif
                </div>
                <div class="md:col-span-2">
                    <strong>Descripción:</strong> 
                    <p class="mt-1 text-gray-700">{{ $evento->descripcion ?? 'Sin descripción' }}</p>
                </div>
            </div>
        </div>

        <!-- Gestión de Inscripciones -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold mb-4">Inscribir Docente</h2>
            
            @if($evento->tieneCuposDisponibles())
                <form action="{{ route('eventos.inscribir', $evento) }}" method="POST" class="flex gap-4 mb-4">
                    @csrf
                    <select name="docente_id" required class="flex-1 px-3 py-2 border rounded">
                        <option value="">Seleccionar docente...</option>
                        @foreach($docentes as $docente)
                            @if(!$evento->docentes->contains($docente->id))
                                <option value="{{ $docente->id }}">
                                    {{ $docente->nombres }} {{ $docente->apellidos }} - {{ $docente->departamento }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Inscribir</button>
                </form>
            @else
                <p class="text-red-500">❌ Cupo completo</p>
            @endif

            <p class="text-sm text-gray-600">
                Cupos disponibles: 
                @if($evento->cupo_maximo)
                    {{ $evento->cupo_maximo - $evento->docentes->count() }}
                @else
                    Ilimitados
                @endif
            </p>
        </div>

        <!-- Lista de Asistentes -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Docentes Inscritos ({{ $asistentes->count() }})</h2>
            
            @if($asistentes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2">Docente</th>
                                <th class="px-4 py-2">Departamento</th>
                                <th class="px-4 py-2">Confirmado</th>
                                <th class="px-4 py-2">Asistió</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistentes as $docente)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $docente->nombres }} {{ $docente->apellidos }}</td>
                                <td class="px-4 py-2">{{ $docente->departamento }}</td>
                                <td class="px-4 py-2">
                                    @if($docente->pivot->confirmado)
                                        <span class="text-green-600">✅ Sí</span>
                                    @else
                                        <span class="text-red-600">❌ No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('eventos.asistencia', $evento) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="docente_id" value="{{ $docente->id }}">
                                        <select name="asistio" onchange="this.form.submit()" class="border rounded">
                                            <option value="0" {{ !$docente->pivot->asistio ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $docente->pivot->asistio ? 'selected' : '' }}>Sí</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('eventos.asistencia', $evento) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="docente_id" value="{{ $docente->id }}">
                                        <input type="hidden" name="asistio" value="{{ $docente->pivot->asistio ? 0 : 1 }}">
                                        <button type="submit" class="text-blue-600 text-sm">
                                            {{ $docente->pivot->asistio ? '❌ Quitar asistencia' : '✅ Marcar asistencia' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No hay docentes inscritos aún.</p>
            @endif
        </div>
    </div>
</body>
</html>