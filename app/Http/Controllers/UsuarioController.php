<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{


    // Verificar si el usuario actual es administrador
    private function esAdministrador()
    {
        $user = Auth::user();
        return $user && $user->rol === 'administrador';
    }

    // Obtener el ID del usuario actual
    private function miId()
    {
        return Auth::id();
    }

    // Listar todos los usuarios
    public function index()
    {
        // Solo administradores pueden ver todos los usuarios
        if (!$this->esAdministrador()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta función');
        }

        $usuarios = Usuario::with('docente')
                          ->orderBy('activo', 'desc')
                          ->orderBy('username')
                          ->get();
        return view('usuarios.index', compact('usuarios'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        // Solo administradores pueden crear usuarios
        if (!$this->esAdministrador()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta función');
        }

        $docentesSinUsuario = Docente::where('activo', true)
                                    ->whereDoesntHave('usuario')
                                    ->get();
        return view('usuarios.create', compact('docentesSinUsuario'));
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $request->validate([
            'docente_id' => 'required|exists:docentes,id|unique:usuarios,docente_id',
            'username' => 'required|string|max:255|unique:usuarios,username',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:administrador,directiva,docente',
        ]);

        Usuario::create([
            'docente_id' => $request->docente_id,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'activo' => true,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    // Mostrar un usuario
    public function show(Usuario $usuario)
    {
        // Usuarios pueden ver solo su propio perfil, administradores pueden ver todos
        if (!$this->esAdministrador() && $this->miId() !== $usuario->id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para ver este usuario');
        }

        return view('usuarios.show', compact('usuario'));
    }

    // Mostrar formulario de editar
    public function edit(Usuario $usuario)
    {
        // Usuarios pueden editar solo su propio perfil, administradores pueden editar todos
        if (!$this->esAdministrador() && $this->miId() !== $usuario->id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para editar este usuario');
        }

        $docentes = Docente::where('activo', true)->get();
        return view('usuarios.edit', compact('usuario', 'docentes'));
    }

    // Actualizar usuario
    public function update(Request $request, Usuario $usuario)
    {
        // Usuarios pueden editar solo su propio perfil, administradores pueden editar todos
        if (!$this->esAdministrador() && $this->miId() !== $usuario->id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para editar este usuario');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:usuarios,username,' . $usuario->id,
            'rol' => 'required|in:administrador,directiva,docente',
            'activo' => 'required|boolean',
        ]);

        $data = $request->only(['username', 'rol', 'activo']);

        // Si se proporciona nueva contraseña
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    // Eliminar usuario
    public function destroy(Usuario $usuario)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para realizar esta acción');
        }

        // No permitir eliminar el propio usuario
        if ($usuario->id === $this->miId()) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar tu propio usuario');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    // Activar usuario
    public function activar(Usuario $usuario)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $usuario->update(['activo' => true]);
        return back()->with('success', 'Usuario activado correctamente');
    }

    // Desactivar usuario
    public function desactivar(Usuario $usuario)
    {
        if (!$this->esAdministrador()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para realizar esta acción');
        }

        // No permitir desactivar el propio usuario
        if ($usuario->id === $this->miId()) {
            return back()->with('error', 'No puedes desactivar tu propio usuario');
        }

        $usuario->update(['activo' => false]);
        return back()->with('success', 'Usuario desactivado correctamente');
    }
}