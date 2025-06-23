<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User; // User modelini eklediğinizden emin olun

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // Örneğin: Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Admin rolü için Gate (Kapı) tanımı
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });

        // Standart Admin rolü için Gate (Kapı) tanımı
        Gate::define('isStandardAdmin', function (User $user) {
            return $user->role === 'standart_admin' || $user->role === 'admin';
        });

        // Makale yazma yetkisi (standart_user, standart_admin, admin)
        // Daha sonra Policy ile detaylandırılabilir, şimdilik genel bir Gate.
        Gate::define('canWriteArticle', function (User $user) {
            return in_array($user->role, ['standart_user', 'standart_admin', 'admin']);
        });

        // Kategori yönetimi yetkisi (sadece admin)
        Gate::define('manageCategories', function (User $user) {
            return $user->role === 'admin';
        });

        // Kullanıcı yönetimi yetkisi (sadece admin)
        Gate::define('manageUsers', function (User $user) {
            return $user->role === 'admin';
        });
    }
}