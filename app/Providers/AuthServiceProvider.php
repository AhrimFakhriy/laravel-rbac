<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider {
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot() {
        $this->registerPolicies();

        if(!Schema::hasTable('permissions'))
            return;

        $permissions = cache()->rememberForever("permissions.slug", fn() => Permission::pluck('slug'));

        $permissions->each(fn($perm) => Gate::define($perm, function(User $user) use ($perm) {
            $userClosure = fn($query) => $query->where('users.id', $user->id);

            $userPermissions = cache()
                ->rememberForever("users.{$user->id}.permissions", fn () =>
                    Permission::whereHas('roles', fn($q) => $q->whereHas('users', $userClosure))
                        ->orWhereHas('users', $userClosure)
                        ->groupBy('permissions.id', 'permissions.slug')
                        ->pluck('slug')
            );

            return $userPermissions->contains($perm);
        }));
    }
}
