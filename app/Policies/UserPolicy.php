<?php

namespace App\Policies;

use App\Models\Users\User as User;
use App\Models\Roles\Role as Role;
use App\Models\Roles\Object as Object;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * The requested objectId.
     *
     * @var string
    */
    protected $objectId;
    
    /**
     * Create a new policy instance.
     *
     * @param  Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        //Get url slug
        $slug = 'user';
     
        if (\Route::current()->hasParameter('user')) {
            $slug .= "-".\Route::input('user')->role->role;
        } elseif ($request->has('role')) {
            $slug .= "-".Role::findOrFail($request->input('role'))->role;
        } else {
            $slug .= '';
        }
 
        $this->objectId = Object::where('slug', $slug)->firstOrFail()->id;
    }

    /**
     * Determine if the given user can view.
     *
     * @param  App\Models\Users\User  $user
     * @return bool
    */
    public function view(User $user)
    {
        return $user->role->permissions()
            ->where('object_id', $this->objectId)
            ->get()
            ->contains('name', __FUNCTION__);
    }

    /**
     * Determine if the given user can create.
     *
     * @param  App\Models\Users\User  $user
     * @return bool
    */
    public function create(User $user)
    {
        return $user->role->permissions()
            ->where('object_id', $this->objectId)
            ->get()
            ->contains('name', __FUNCTION__);
    }

    /**
     * Determine if the given user can update.
     *
     * @param  App\Models\Users\User  $user
     * @return bool
    */
    public function update(User $user)
    {
        return $user->role->permissions()
            ->where('object_id', $this->objectId)
            ->get()
            ->contains('name', __FUNCTION__);
    }

    /**
     * Determine if the given user can delete.
     *
     * @param  App\Models\Users\User  $user
     * @return bool
    */
    public function delete(User $user)
    {
        return $user->role->permissions()
            ->where('object_id', $this->objectId)
            ->get()
            ->contains('name', __FUNCTION__);
    }
}
