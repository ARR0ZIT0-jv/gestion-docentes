<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Crear Nuevo Usuario</h1>

        <form action="{{ route('usuarios.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2 font-medium">Docente *</label>
                <select name="docente_id" required class="w-full px-3 py-2 border rounded">
                    <option value="">Seleccionar docente...</option>
                    @foreach($docentesSinUsuario as $docente)
                        <option value="{{ $docente->id }}">
                            {{ $docente->nombres }} {{ $docente->apellidos }} - {{ $docente->departamento }}
                        </option>
                    @endforeach
                </select>
                <small class="text-gray-500">Solo se muestran docentes que no tienen usuario asignado</small>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Nombre de Usuario *</label>
                <input type="text" name="username" required 
                       class="w-full px-3 py-2 border rounded" placeholder="Nombre de usuario único">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">Contraseña *</label>
                    <input type="password" name="password" required 
                           class="w-full px-3 py-2 border rounded" placeholder="Mínimo 6 caracteres">
                </div>
                
                <div>
                    <label class="block mb-2 font-medium">Confirmar Contraseña *</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Rol *</label>
                <select name="rol" required class="w-full px-3 py-2 border rounded">
                    <option value="docente">Docente</option>
                    <option value="directiva">Directiva</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    👥 Crear Usuario
                </button>
                <a href="{{ route('usuarios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Cancelar
                </a>
            </div>
        </form>

        @if($docentesSinUsuario->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mt-4">
            ⚠️ Todos los docentes activos ya tienen usuario asignado. 
            <a href="{{ route('docentes.create') }}" class="underline">Crear nuevo docente</a> para asignarle usuario.
        </div>
        @endif
    </div>
</body>
</html>