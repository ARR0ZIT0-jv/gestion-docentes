<!DOCTYPE html>
<html>
<head>
    <title>Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Docentes</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('docentes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            Nuevo Docente
        </a>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Departamento</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($docentes as $docente)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $docente->id }}</td>
                        <td class="px-4 py-2">{{ $docente->nombres }} {{ $docente->apellidos }}</td>
                        <td class="px-4 py-2">{{ $docente->email }}</td>
                        <td class="px-4 py-2">{{ $docente->departamento }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('docentes.show', $docente) }}" class="text-blue-600 mr-2">Ver</a>
                            <a href="{{ route('docentes.edit', $docente) }}" class="text-green-600 mr-2">Editar</a>
                            <form action="{{ route('docentes.destroy', $docente) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>