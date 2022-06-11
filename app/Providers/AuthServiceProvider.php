<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('admin', function ($user) {
            return $user->role->nama === 'Administrator';
        });

        Gate::define('kepala_sekolah', function ($user) {
            return $user->role->nama === 'Kepala Sekolah';
        });

        Gate::define('wakil_sarpras', function ($user) {
            return $user->role->nama === 'Wakil Sarpras';
        });

        Gate::define('staff_administrasi', function ($user) {
            return $user->role->nama === 'Staff Administrasi';
        });

        Gate::define('bendahara', function ($user) {
            return $user->role->nama === 'Bendahara';
        });

        Gate::define('validator', function ($user) {
            return $user->role->nama === 'Kepala Sekolah' || $user->role->nama === 'Wakil Sarpras';
        });

        Gate::define('manage_data', function ($user) {
            return $user->role->nama === 'Administrator' || $user->role->nama === 'Staff Administrasi';
        });
    }
}
