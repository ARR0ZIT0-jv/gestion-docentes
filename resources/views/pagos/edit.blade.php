<!DOCTYPE html>
<html>
<head>
    <title>Editar Pago - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Editar Pago #{{ $pago->id }}</h1>

        <form action="{{ route('pagos.update', $pago) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block mb-2 font-medium">Docente *</label>
                <select name="docente_id" required class="w-full px-3 py-2 border rounded bg-gray-50" disabled>
                    <option value="{{ $pago->docente_id }}" selected>
                        {{ $pago->docente->nombres }} {{ $pago->docente->apellidos }} - {{ $pago->docente->departamento }}
                    </option>
                </select>
                <small class="text-gray-500">No se puede cambiar el docente después de creado el pago</small>
                <input type="hidden" name="docente_id" value="{{ $pago->docente_id }}">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">Monto *</label>
                    <input type="number" name="monto" step="0.01" min="0" required 
                           value="{{ $pago->monto }}" class="w-full px-3 py-2 border rounded">
                </div>
                
                <div>
                    <label class="block mb-2 font-medium">Concepto *</label>
                    <input type="text" name="concepto" required value="{{ $pago->concepto }}"
                           class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">Periodo *</label>
                    <input type="text" name="periodo" required value="{{ $pago->periodo }}"
                           class="w-full px-3 py-2 border rounded" placeholder="Ej: Enero 2024">
                </div>
                
                <div>
                    <label class="block mb-2 font-medium">Fecha de Pago *</label>
                    <input type="date" name="fecha_pago" required 
                           value="{{ $pago->fecha_pago->format('Y-m-d') }}" class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Método de Pago *</label>
                <select name="metodo" required class="w-full px-3 py-2 border rounded">
                    <option value="efectivo" {{ $pago->metodo == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="transferencia" {{ $pago->metodo == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    <option value="tarjeta" {{ $pago->metodo == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="otros" {{ $pago->metodo == 'otros' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Número de Comprobante</label>
                <input type="text" name="comprobante" value="{{ $pago->comprobante }}"
                       class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Observaciones</label>
                <textarea name="observaciones" class="w-full px-3 py-2 border rounded" rows="3">{{ $pago->observaciones }}</textarea>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="verificado" value="1" 
                           {{ $pago->verificado ? 'checked' : '' }} class="mr-2">
                    <span class="font-medium">Pago verificado</span>
                </label>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    💾 Actualizar Pago
                </button>
                <a href="{{ route('pagos.show', $pago) }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    ↩️ Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>