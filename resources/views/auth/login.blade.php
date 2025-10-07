<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema Gestión Docentes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Sistema de Gestión de Docentes</h1>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Usuario:</label>
                <input type="text" name="username" required 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                       value="{{ old('username') }}">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Contraseña:</label>
                <input type="password" name="password" required 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" 
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Iniciar Sesión
            </button>
        </form>

        <div class="mt-4 text-center text-sm text-gray-600">
            <p>Usuario demo: <strong>admin</strong> / Contraseña: <strong>password123</strong></p>
        </div>
    </div>
</body>
</html>