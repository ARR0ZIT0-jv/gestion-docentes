<!DOCTYPE html>
<html>
<head>
    <title>Usuarios del Sistema</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Gestión de Usuarios del Sistema</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(Auth::user()->rol === 'administrador')
        <a href="{{ route('usuarios.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            👥 Crear Nuevo Usuario
        </a>
        @endif

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-blue-600">{{ $usuarios->count() }}</div>
                <div class="text-gray-600">Total Usuarios</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-green-600">{{ $usuarios->where('activo', true)->count() }}</div>
                <div class="text-gray-600">Usuarios Activos</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-red-600">{{ $usuarios->where('activo', false)->count() }}</div>
                <div class="text-gray-600">Usuarios Inactivos</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-2xl font-bold text-purple-600">{{ $usuarios->where('rol', 'administrador')->count() }}</div>
                <div class="text-gray-600">Administradores</div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Usuario</th>
                        <th class="px-4 py-2">Docente Asociado</th>
                        <th class="px-4 py-2">Rol</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Última Actualización</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">
                            <strong>{{ $usuario->username }}</strong>
                            @if($usuario->id === Auth::user()->id)
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded ml-2">Tú</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($usuario->docente)
                                {{ $usuario->docente->nombres }} {{ $usuario->docente->apellidos }}
                            @else
                                <span class="text-red-500">No asociado</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($usuario->rol === 'administrador') bg-purple-100 text-purple-800
                                @elseif($usuario->rol === 'directiva') bg-green-100 text-green-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($usuario->rol) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @if($usuario->activo)
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Activo</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $usuario->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('usuarios.show', $usuario) }}" class="text-blue-600 mr-2">👁️</a>
                            
                            @if(Auth::user()->rol === 'administrador' || Auth::user()->id === $usuario->id)
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="text-green-600 mr-2">✏️</a>
                            @endif
                            
                            @if(Auth::user()->rol === 'administrador')
                                @if($usuario->activo && Auth::user()->id !== $usuario->id)
                                    <form action="{{ route('usuarios.desactivar', $usuario) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 mr-2" 
                                                onclick="return confirm('¿Desactivar usuario?')">⏸️</button>
                                    </form>
                                @elseif(!$usuario->activo)
                                    <form action="{{ route('usuarios.activar', $usuario) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 mr-2">▶️</button>
                                    </form>
                                @endif

                                @if(Auth::user()->id !== $usuario->id)
                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600" 
                                                onclick="return confirm('¿Eliminar usuario permanentemente?')">🗑️</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Información adicional -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded p-4">
            <h3 class="font-bold text-blue-800 mb-2">📋 Información sobre permisos:</h3>
            <ul class="text-blue-700 text-sm space-y-1">
                <li>• <strong>Administradores</strong> pueden gestionar todos los usuarios</li>
                <li>• <strong>Directiva y Docentes</strong> solo pueden ver y editar su propio perfil</li>
                <li>• Los usuarios marcados con <span class="bg-blue-100 text-blue-800 px-1 rounded">"Tú"</span> son tu propio usuario</li>
                <li>• Los usuarios <span class="bg-red-100 text-red-800 px-1 rounded">inactivos</span> no pueden iniciar sesión</li>
            </ul>
        </div>
    </div>
</body>
</html>