<?php

namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Hash;
use App\Role;
class RootUserProvider extends EloquentUserProvider
{
    /**
     * ID reservado para el usuario root (debe ser uno que no exista en tu BD)
     */
    const ROOT_ID = -999;

    /**
     * Recuperar usuario por sus credenciales (Login).
     */
    public function retrieveByCredentials(array $credentials)
    {
        // 1. Verificar si las credenciales coinciden con las del ROOT en el .env
        $rootEmail = env('ROOT_EMAIL');
        $inputEmail = $credentials['email'] ?? null;

        if ($rootEmail && $inputEmail === $rootEmail) {
            return $this->getRootUserInstance();
        }

        // 2. Si no es root, usar el comportamiento normal (buscar en BD)
        return parent::retrieveByCredentials($credentials);
    }

    /**
     * Recuperar usuario por ID (Sesión activa).
     */
    public function retrieveById($identifier)
    {
        // 1. Si el ID en sesión es el del ROOT, devolvemos la instancia en memoria
        if ($identifier == self::ROOT_ID) {
            return $this->getRootUserInstance();
        }

        // 2. Si no, buscar en BD
        return parent::retrieveById($identifier);
    }

    /**
     * Validar contraseña.
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        // Si es el usuario Root, validamos contra el .env
        if ($user->getAuthIdentifier() == self::ROOT_ID) {
            return $credentials['password'] === env('ROOT_PASSWORD');
        }

        // Si es usuario normal, validamos hash normal
        return parent::validateCredentials($user, $credentials);
    }

    /**
     * Crea la instancia del usuario fantasma en memoria.
     */
    private function getRootUserInstance()
    {
        $modelClass = $this->getModel();
        $user = new $modelClass;

        $user->forceFill([
            'id' => self::ROOT_ID,
            'name' => 'System Root',
            'email' => env('ROOT_EMAIL'),
            'password' => Hash::make(env('ROOT_PASSWORD')),
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 'active', 
        ]);

        $user->exists = true; 

        // --- MAGIA AQUÍ: Asignación de Rol en Memoria ---
        // Buscamos el rol 'admin' que creamos con el Seeder
        // Usamos setRelation para inyectarlo como si hubiera venido de la BD
        try {
            $adminRole = Role::where('name', 'admin')->first();
            
            if ($adminRole) {
                // Spatie usa una relación llamada 'roles'. 
                // Creamos una colección con el rol y se la inyectamos manualmente.
                $user->setRelation('roles', collect([$adminRole]));
            }
        } catch (\Exception $e) {
            // Si la tabla roles no existe o falla, ignoramos para no romper el login
        }
        // ------------------------------------------------

        return $user;
    }
}