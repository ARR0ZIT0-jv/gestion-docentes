<!DOCTYPE html>
<html>
<head>
    <title>Registrar Pago</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Registrar Nuevo Pago</h1>

        <form action="{{ route('pagos.store') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2">Docente *</label>
                <select name="docente_id" required class="w-full px-3 py-2 border rounded">
                    <option value="">Seleccionar docente...</option>
                    @foreach($docentes as $docente)
                        <option value="{{ $docente->id }}">
                            {{ $docente->nombres }} {{ $docente->apellidos }} - {{ $docente->departamento }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2">Monto *</label>
                    <input type="number" name="monto" step="0.01" min="0" required 
                           class="w-full px-3 py-2 border rounded" placeholder="0.00">
                </div>
                
                <div>
                    <label class="block mb-2">Concepto *</label>
                    <input type="text" name="concepto" required 
                           class="w-full px-3 py-2 border rounded" placeholder="Cuota mensual, matrícula, etc.">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2">Periodo *</label>
                    <input type="text" name="periodo" required 
                           class="w-full px-3 py-2 border rounded" placeholder="Ej: Enero 2024, Q1 2024">
                </div>
                
                <div>
                    <label class="block mb-2">Fecha de Pago *</label>
                    <input type="date" name="fecha_pago" required 
                           class="w-full px-3 py-2 border rounded" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Método de Pago *</label>
                <select name="metodo" required class="w-full px-3 py-2 border rounded">
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="otros">Otros</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2">Número de Comprobante (opcional)</label>
                <input type="text" name="comprobante" 
                       class="w-full px-3 py-2 border rounded" placeholder="Número de transacción o recibo">
            </div>

            <div class="mb-4">
                <label class="block mb-2">Observaciones (opcional)</label>
                <textarea name="observaciones" class="w-full px-3 py-2 border rounded" rows="3"
                          placeholder="Observaciones adicionales..."></textarea>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Registrar Pago</button>
                <a href="{{ route('pagos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>