<?php

namespace App\Providers;

use App\Policies\UserPolicy as UserPolicy;
use App\Models\Users\User as User;
use App\Models\Roles\Object as Object;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies;
        
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('view', function ($user, $object) {
            $objectId = Object::where('slug', $object)
                ->firstOrFail()
                ->id;
            return $user->role->permissions()
            ->where('object_id', $objectId)
            ->get()
            ->contains('name', 'view');
        });

        Gate::define('create', function ($user, $object) {
            $objectId = Object::where('slug', $object)
                ->firstOrFail()
                ->id;
            return $user->role->permissions()
            ->where('object_id', $objectId)
            ->get()
            ->contains('name', 'create');
        });

        Gate::define('update', function ($user, $object) {
            $objectId = Object::where('slug', $object)
                ->firstOrFail()
                ->id;
            return $user->role->permissions()
            ->where('object_id', $objectId)
            ->get()
            ->contains('name', 'update');
        });

        Gate::define('delete', function ($user, $object) {
            $objectId = Object::where('slug', $object)
                ->firstOrFail()
                ->id;
            return $user->role->permissions()
            ->where('object_id', $objectId)
            ->get()
            ->contains('name', 'delete');
        });
    }
}
