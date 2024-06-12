<?php

namespace App\Providers;

use App\Analisis;
use App\AnalisisSupervisor;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-users', function($user){
            return $user->hasRole('admin');
        });
        Gate::define('delete-users', function($user){
            return $user->hasRole('admin');
        });
        Gate::define('manage-admin', function($user){
            return $user->hasAnyRoles(['admin']);
        });
        Gate::define('manage-users', function($user){
            return $user->hasAnyRoles(['admin', 'secretaria']);
        });
        Gate::define('manage-users-dr', function($user){
            return $user->hasAnyRoles(['admin', 'secretaria', 'medico']);
        });
        Gate::define('manage-users-dr1', function($user){
            return $user->hasAnyRoles(['admin', 'medico']);
        });
        Gate::define('manage-users-dr2', function($user, $analisis){
            $analisisSupervisor = AnalisisSupervisor::where('doctor_id', $user->person)->where('analisis_id', $analisis->id)->first();
            return $user->hasAnyRoles(['admin', 'medico']) || ($analisisSupervisor);
        });
        Gate::define('manage-users-dr3', function($user, $analisis){
            return $user->hasRole('admin') || ($user->hasRole('medico') && $analisis->doctor_asignado == $user->person);
        });
        Gate::define('manage-users-tecnico', function($user){
            return $user->hasAnyRoles(['admin', 'secretaria', 'tecnico']);
        });
        Gate::define('manage-users-all', function($user){
            return $user->hasAnyRoles(['admin', 'secretaria', 'tecnico', 'medico']);
        });
        Gate::define('manage-users-only-tecnico', function($user){
            return $user->hasAnyRoles(['tecnico']);
        });
        Gate::define('manage-users-only-secretaria', function($user){
            return $user->hasAnyRoles(['secretaria']);
        });
        Gate::define('manage-users-no-tecnico', function($user){
            return $user->hasAnyRoles(['secretaria', 'medico', 'invitado']);
        });
        Gate::define('manage-users-no-medico', function($user){
            return $user->hasAnyRoles(['secretaria', 'tecnico']);
        });
        Gate::define('is-invitado', function($user){
            return $user->hasAnyRoles(['invitado']);
        });
    }
}
