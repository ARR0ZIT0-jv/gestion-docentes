<!DOCTYPE html>
<html>
<head>
    <title>Editar Evento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Editar Evento: {{ $evento->titulo }}</h1>

        <form action="{{ route('eventos.update', $evento) }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block mb-2">Título *</label>
                <input type="text" name="titulo" value="{{ $evento->titulo }}" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Descripción</label>
                <textarea name="descripcion" class="w-full px-3 py-2 border rounded" rows="3">{{ $evento->descripcion }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2">Fecha Inicio *</label>
                    <input type="datetime-local" name="fecha_inicio" 
                           value="{{ $evento->fecha_inicio->format('Y-m-d\TH:i') }}" required 
                           class="w-full px-3 py-2 border rounded">
                </div>
                
                <div>
                    <label class="block mb-2">Fecha Fin *</label>
                    <input type="datetime-local" name="fecha_fin" 
                           value="{{ $evento->fecha_fin->format('Y-m-d\TH:i') }}" required 
                           class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Lugar</label>
                <input type="text" name="lugar" value="{{ $evento->lugar }}" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-2">Tipo *</label>
                <select name="tipo" required class="w-full px-3 py-2 border rounded">
                    <option value="reunion" {{ $evento->tipo == 'reunion' ? 'selected' : '' }}>Reunión</option>
                    <option value="seminario" {{ $evento->tipo == 'seminario' ? 'selected' : '' }}>Seminario</option>
                    <option value="taller" {{ $evento->tipo == 'taller' ? 'selected' : '' }}>Taller</option>
                    <option value="social" {{ $evento->tipo == 'social' ? 'selected' : '' }}>Social</option>
                    <option value="otros" {{ $evento->tipo == 'otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Estado *</label>
                <select name="estado" required class="w-full px-3 py-2 border rounded">
                    <option value="planificado" {{ $evento->estado == 'planificado' ? 'selected' : '' }}>Planificado</option>
                    <option value="confirmado" {{ $evento->estado == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="en_curso" {{ $evento->estado == 'en_curso' ? 'selected' : '' }}>En Curso</option>
                    <option value="finalizado" {{ $evento->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    <option value="cancelado" {{ $evento->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Cupo Máximo (opcional)</label>
                <input type="number" name="cupo_maximo" value="{{ $evento->cupo_maximo }}" min="1" class="w-full px-3 py-2 border rounded">
                <small class="text-gray-500">Dejar vacío para cupo ilimitado. Actual: {{ $evento->docentes->count() }} inscritos</small>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar Evento</button>
                <a href="{{ route('eventos.show', $evento) }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>