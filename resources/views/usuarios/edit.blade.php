<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario: {{ $usuario->username }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Editar Usuario: {{ $usuario->username }}</h1>

        <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block mb-2 font-medium">Nombre de Usuario *</label>
                <input type="text" name="username" value="{{ $usuario->username }}" required 
                       class="w-full px-3 py-2 border rounded">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Nueva Contraseña (opcional)</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded" placeholder="Dejar vacío para no cambiar">
                <small class="text-gray-500">Mínimo 6 caracteres</small>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" 
                       class="w-full px-3 py-2 border rounded">
            </div>

            @if(auth()->user()->rol === 'administrador')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">Rol *</label>
                    <select name="rol" required class="w-full px-3 py-2 border rounded">
                        <option value="docente" {{ $usuario->rol == 'docente' ? 'selected' : '' }}>Docente</option>
                        <option value="directiva" {{ $usuario->rol == 'directiva' ? 'selected' : '' }}>Directiva</option>
                        <option value="administrador" {{ $usuario->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>
                
                <div>
                    <label class="block mb-2 font-medium">Estado *</label>
                    <select name="activo" required class="w-full px-3 py-2 border rounded">
                        <option value="1" {{ $usuario->activo ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
            @else
            <input type="hidden" name="rol" value="{{ $usuario->rol }}">
            <input type="hidden" name="activo" value="{{ $usuario->activo }}">
            @endif

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    💾 Actualizar Usuario
                </button>
                <a href="{{ route('usuarios.show', $usuario) }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    ↩️ Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>