<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sistema Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-xl font-bold">Sistema de Gestión Docentes</div>
                <div class="flex items-center space-x-4">
                    <span>Bienvenido, {{ Auth::user()->username }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Dashboard Principal</h1>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-2xl font-bold text-blue-600">
                    {{ App\Models\Docente::where('activo', true)->count() }}
                </div>
                <div class="text-gray-600">Docentes Activos</div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-2xl font-bold text-green-600">
                    {{ App\Models\Usuario::where('activo', true)->count() }}
                </div>
                <div class="text-gray-600">Usuarios del Sistema</div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-2xl font-bold text-purple-600">
                    {{ App\Models\Evento::count() }}
                </div>
                <div class="text-gray-600">Eventos Programados</div>
            </div>
        </div>

        <!-- Menú de acciones -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Acciones Rápidas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('docentes.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg block">
                    👥 Gestión de Docentes
                </a>
               <a href="{{ route('eventos.index') }}" class="bg-green-500 hover:bg-green-700 text-white text-center py-3 px-4 rounded-lg block">
    📅 Gestión de Eventos
</a>
               <a href="{{ route('pagos.index') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-center py-3 px-4 rounded-lg block">
    💰 Gestión de Pagos
</a>
                <a href="#" class="bg-purple-500 hover:bg-purple-700 text-white text-center py-3 px-4 rounded-lg block">
                    ⚙️ Configuración
                </a>
            </div>
        </div>
    @if(Auth::user()->rol === 'administrador')
<a href="{{ route('usuarios.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white text-center py-3 px-4 rounded-lg block">
    👥 Gestión de Usuarios
</a>
<a href="{{ route('directiva.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg block">
    🏛️ Directiva de la Asociación
</a>
<a href="{{ route('cargos-universitarios.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white text-center py-3 px-4 rounded-lg block">
    🎓 Cargos Universitarios
</a>
@endif

        <!-- Información del usuario -->
        <div class="bg-white p-6 rounded-lg shadow mt-6">
            <h2 class="text-xl font-bold mb-4">Información de Sesión</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <strong>Usuario:</strong> {{ Auth::user()->username }}
                </div>
                <div>
                    <strong>Rol:</strong> {{ Auth::user()->rol }}
                </div>
                <div>
                    <strong>Docente asociado:</strong> 
                    @if(Auth::user()->docente)
                        {{ Auth::user()->docente->nombres }} {{ Auth::user()->docente->apellidos }}
                    @else
                        No asociado
                    @endif
                </div>
                <div>
                    <strong>Email:</strong> 
                    @if(Auth::user()->docente)
                        {{ Auth::user()->docente->email }}
                    @else
                        No disponible
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>