<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(now()->addSeconds(60));

        // Establecer los permisos de los tokens
        Passport::tokensCan([
            'create-post' => 'Crear un post',
            'read-post' => 'Leer un post',
            'update-post' => 'Actualziar un post',
            'delete-post' => 'Eliminar un post'
        ]);

        // Permitir lectura a los post por defecto en todos los permisos
        Passport::setDefaultScope([
            'read-post'
        ]);
    }
}
