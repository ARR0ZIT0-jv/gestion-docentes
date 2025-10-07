<!DOCTYPE html>
<html>
<head>
    <title>Agregar a Directiva</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Agregar Miembro a Directiva</h1>

        <form action="{{ route('directiva.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2 font-medium">Docente *</label>
                <select name="docente_id" required class="w-full px-3 py-2 border rounded">
                    <option value="">Seleccionar docente...</option>
                    @foreach($docentes as $docente)
                        <option value="{{ $docente->id }}">
                            {{ $docente->nombres }} {{ $docente->apellidos }} - {{ $docente->departamento }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Cargo *</label>
                <input type="text" name="cargo" required 
                       class="w-full px-3 py-2 border rounded" placeholder="Ej: Presidente, Secretario, Tesorero...">
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Descripción del Cargo</label>
                <textarea name="descripcion" class="w-full px-3 py-2 border rounded" rows="3"
                          placeholder="Funciones y responsabilidades del cargo..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">Fecha Inicio *</label>
                    <input type="date" name="fecha_inicio" required 
                           class="w-full px-3 py-2 border rounded" value="{{ date('Y-m-d') }}">
                </div>
                
                <div>
                    <label class="block mb-2 font-medium">Fecha Fin *</label>
                    <input type="date" name="fecha_fin" required 
                           class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    ➕ Agregar a Directiva
                </button>
                <a href="{{ route('directiva.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>