<!DOCTYPE html>
<html>
<head>
    <title>Editar Docente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Editar Docente</h1>

        <form action="{{ route('docentes.update', $docente) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Nombres:</label>
                    <input type="text" name="nombres" value="{{ $docente->nombres }}" required 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div>
                    <label class="block text-gray-700">Apellidos:</label>
                    <input type="text" name="apellidos" value="{{ $docente->apellidos }}" required 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div>
                    <label class="block text-gray-700">Email:</label>
                    <input type="email" name="email" value="{{ $docente->email }}" required 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div>
                    <label class="block text-gray-700">Teléfono:</label>
                    <input type="text" name="telefono" value="{{ $docente->telefono }}" 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div>
                    <label class="block text-gray-700">Departamento:</label>
                    <input type="text" name="departamento" value="{{ $docente->departamento }}" required 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div>
                    <label class="block text-gray-700">Grado Académico:</label>
                    <input type="text" name="grado_academico" value="{{ $docente->grado_academico }}" 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div>
                    <label class="block text-gray-700">Fecha de Ingreso:</label>
                    <input type="date" name="fecha_ingreso" value="{{ $docente->fecha_ingreso->format('Y-m-d') }}" required 
                           class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Actualizar
                </button>
                <a href="{{ route('docentes.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>