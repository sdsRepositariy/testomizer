<?php

namespace App\Http\Controllers\Users\Teachers;

use App\Models\Users\User as User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    /**
     * Restore soft deleted users.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function restoreTrashed($user)
    {
        if (\Gate::denies('delete', 'user-'.$user->role->role)) {
            abort(403);
        }
 
        //Restore user data
        $user->restore();
        
        $message = [
            'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_restored')
        ];

        return back()->with($message);
    }

    /**
     * Remove the user from data base.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function hardDelete($user)
    {
        if (\Gate::denies('delete', 'user-'.$user->role->role)) {
            abort(403);
        }

        //Delete the user
        $user->forceDelete();

        $message = [
            'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_deleted')
        ];

        return back()->with($message);
    }
}
