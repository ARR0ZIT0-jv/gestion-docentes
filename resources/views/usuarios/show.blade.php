<!DOCTYPE html>
<html>
<head>
    <title>Usuario: {{ $usuario->username }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Usuario: {{ $usuario->username }}</h1>
            <div class="flex space-x-2">
                @if(auth()->user()->rol === 'administrador' || auth()->user()->id === $usuario->id)
                <a href="{{ route('usuarios.edit', $usuario) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">✏️ Editar</a>
                @endif
                <a href="{{ route('usuarios.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">📋 Lista de Usuarios</a>
            </div>
        </div>

        <!-- Información del Usuario -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold mb-4">Información de la Cuenta</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Usuario:</strong> {{ $usuario->username }}</div>
                <div><strong>Rol:</strong> 
                    <span class="px-2 py-1 rounded text-xs 
                        @if($usuario->rol === 'administrador') bg-purple-100 text-purple-800
                        @elseif($usuario->rol === 'directiva') bg-green-100 text-green-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($usuario->rol) }}
                    </span>
                </div>
                <div><strong>Estado:</strong> 
                    @if($usuario->activo)
                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Activo</span>
                    @else
                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Inactivo</span>
                    @endif
                </div>
                <div><strong>Docente Asociado:</strong> 
                    @if($usuario->docente)
                        {{ $usuario->docente->nombres }} {{ $usuario->docente->apellidos }}
                    @else
                        <span class="text-red-500">No asociado</span>
                    @endif
                </div>
                <div><strong>Departamento:</strong> 
                    @if($usuario->docente)
                        {{ $usuario->docente->departamento }}
                    @else
                        <span class="text-red-500">No disponible</span>
                    @endif
                </div>
                <div><strong>Email:</strong> 
                    @if($usuario->docente)
                        {{ $usuario->docente->email }}
                    @else
                        <span class="text-red-500">No disponible</span>
                    @endif
                </div>
                <div><strong>Cuenta creada:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</div>
                <div><strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <!-- Información del Docente (si está asociado) -->
        @if($usuario->docente)
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Información del Docente Asociado</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Nombres:</strong> {{ $usuario->docente->nombres }}</div>
                <div><strong>Apellidos:</strong> {{ $usuario->docente->apellidos }}</div>
                <div><strong>Email:</strong> {{ $usuario->docente->email }}</div>
                <div><strong>Teléfono:</strong> {{ $usuario->docente->telefono ?? 'No especificado' }}</div>
                <div><strong>Departamento:</strong> {{ $usuario->docente->departamento }}</div>
                <div><strong>Fecha de Ingreso:</strong> {{ $usuario->docente->fecha_ingreso->format('d/m/Y') }}</div>
                <div><strong>Grado Académico:</strong> {{ $usuario->docente->grado_academico ?? 'No especificado' }}</div>
                <div><strong>Estado:</strong> 
                    @if($usuario->docente->activo)
                        <span class="text-green-600">Activo</span>
                    @else
                        <span class="text-red-600">Inactivo</span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>