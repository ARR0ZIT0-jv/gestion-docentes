<!DOCTYPE html>
<html>
<head>
    <title>Registrar Cargo Universitario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Registrar Cargo de Representación Universitaria</h1>

        <form action="{{ route('cargos-universitarios.store') }}" method="POST" class="bg-white p-6 rounded shadow">
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
                <label class="block mb-2 font-medium">Órgano Universitario *</label>
                <select name="organo" required class="w-full px-3 py-2 border rounded">
                    <option value="">Seleccionar órgano...</option>
                    <option value="Consejo Universitario">Consejo Universitario</option>
                    <option value="Consejo de Facultad">Consejo de Facultad</option>
                    <option value="Comisión Académica">Comisión Académica</option>
                    <option value="Comisión de Investigación">Comisión de Investigación</option>
                    <option value="Comisión de Extensión">Comisión de Extensión</option>
                    <option value="Junta de Departamento">Junta de Departamento</option>
                    <option value="Otro">Otro órgano</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Cargo *</label>
                <input type="text" name="cargo" required 
                       class="w-full px-3 py-2 border rounded" placeholder="Ej: Representante, Vocal, Secretario...">
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Periodo *</label>
                <input type="text" name="periodo" required 
                       class="w-full px-3 py-2 border rounded" placeholder="Ej: 2024-2025, Q1 2024">
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Funciones y Responsabilidades</label>
                <textarea name="funciones" class="w-full px-3 py-2 border rounded" rows="4"
                          placeholder="Descripción de las funciones del cargo..."></textarea>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    ➕ Registrar Cargo
                </button>
                <a href="{{ route('cargos-universitarios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>