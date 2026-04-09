<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados pueden acceder a su perfil
        $this->middleware('auth');
    }

    /**
     * Muestra el formulario de edición del perfil del usuario en sesión.
     */
    public function edit()
    {
        $user = Auth::user();
        // Si el usuario tiene rol de médico, cargamos su doctor relacionado
        $doctor = null;
        if ($user->hasRole('medico') && $user->person) {
            $doctor = Doctor::find($user->person);
        }

        return view('profile.edit', compact('user', 'doctor'));
    }

    /**
     * Procesa y guarda los cambios del perfil del usuario en sesión.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Reglas de validación base
        $rules = [
            'name'  => 'required|max:255',
        ];

        // Validar contraseña solo si el usuario envió algo en ese campo
        if ($request->filled('password')) {
            $rules['password']              = 'min:6|confirmed';
            $rules['password_confirmation'] = 'min:6';
        }

        // Validar firma solo si el usuario es médico y subió un archivo
        if ($user->hasRole('medico') && $request->hasFile('signing_file')) {
            $rules['signing_file'] = 'file|mimes:jpg,jpeg,png,gif|max:2048';
        }

        $request->validate($rules);

        // Actualizar datos básicos del usuario
        $user->name  = $request->name;
        // $user->email = $request->email;

        // Actualizar contraseña solo si se proporcionó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Si es médico, actualizar la firma en la tabla doctores
        if ($user->hasRole('medico') && $user->person && $request->hasFile('signing_file')) {
            $doctor = Doctor::find($user->person);

            if ($doctor) {
                $file     = $request->file('signing_file');
                $fileName = time() . '.' . $file->extension();
                $file->move(public_path('uploads/signings/'), $fileName);

                $doctor->signing = $fileName;
                $doctor->save();
            }
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
