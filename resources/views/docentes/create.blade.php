<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Docente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Nuevo Docente</h1>

        <form action="{{ route('docentes.store') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2">Nombres:</label>
                <input type="text" name="nombres" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Apellidos:</label>
                <input type="text" name="apellidos" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Email:</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Teléfono:</label>
                <input type="text" name="telefono" class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Departamento:</label>
                <input type="text" name="departamento" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Fecha Ingreso:</label>
                <input type="date" name="fecha_ingreso" required class="w-full px-3 py-2 border rounded">
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                <a href="{{ route('docentes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>