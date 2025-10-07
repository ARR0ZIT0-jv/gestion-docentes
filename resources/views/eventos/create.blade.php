<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Evento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Nuevo Evento</h1>

        <form action="{{ route('eventos.store') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2">Título *</label>
                <input type="text" name="titulo" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Descripción</label>
                <textarea name="descripcion" class="w-full px-3 py-2 border rounded" rows="3"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2">Fecha Inicio *</label>
                    <input type="datetime-local" name="fecha_inicio" required class="w-full px-3 py-2 border rounded">
                </div>
                
                <div>
                    <label class="block mb-2">Fecha Fin *</label>
                    <input type="datetime-local" name="fecha_fin" required class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Lugar</label>
                <input type="text" name="lugar" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-2">Tipo *</label>
                <select name="tipo" required class="w-full px-3 py-2 border rounded">
                    <option value="reunion">Reunión</option>
                    <option value="seminario">Seminario</option>
                    <option value="taller">Taller</option>
                    <option value="social">Social</option>
                    <option value="otros">Otros</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Cupo Máximo (opcional)</label>
                <input type="number" name="cupo_maximo" min="1" class="w-full px-3 py-2 border rounded">
                <small class="text-gray-500">Dejar vacío para cupo ilimitado</small>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Evento</button>
                <a href="{{ route('eventos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>