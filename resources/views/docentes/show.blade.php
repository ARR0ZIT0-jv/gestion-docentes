<!DOCTYPE html>
<html>
<head>
    <title>Ver Docente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Información del Docente</h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <strong>ID:</strong> {{ $docente->id }}
                </div>
                <div>
                    <strong>Nombres:</strong> {{ $docente->nombres }}
                </div>
                <div>
                    <strong>Apellidos:</strong> {{ $docente->apellidos }}
                </div>
                <div>
                    <strong>Email:</strong> {{ $docente->email }}
                </div>
                <div>
                    <strong>Teléfono:</strong> {{ $docente->telefono ?? 'No especificado' }}
                </div>
                <div>
                    <strong>Departamento:</strong> {{ $docente->departamento }}
                </div>
                <div>
                    <strong>Grado Académico:</strong> {{ $docente->grado_academico ?? 'No especificado' }}
                </div>
                <div>
                    <strong>Fecha de Ingreso:</strong> {{ $docente->fecha_ingreso->format('d/m/Y') }}
                </div>
                <div>
                    <strong>Estado:</strong> 
                    <span class="{{ $docente->activo ? 'text-green-600' : 'text-red-600' }}">
                        {{ $docente->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('docentes.edit', $docente) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('docentes.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </div>
</body>
</html>