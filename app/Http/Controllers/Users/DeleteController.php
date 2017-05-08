<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\User as User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    /**
     * Restore soft deleted users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreTrashed($id)
    {
        dd('delete');
        $this->authorize('delete', User::class);
        
        $user = User::onlyTrashed()->findOrFail($id);

        //Restore user data
        $user->restore();
        $user->admin->restore();

        $message = [
            'flash_message'=>'The user'.'&nbsp;'
            .$user->first_name.'&nbsp;'.$user->last_name
            .'&nbsp;'.'was successfully restored'
        ];

        return back()->with($message);
    }

    /**
     * Remove the user from data base.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hardDelete($id)
    {
        $this->authorize('delete', User::class);
        $user = User::onlyTrashed()->findOrFail($id);

        //Delete the user
        $user->forceDelete();
        $user->admin->forceDelete();

        $message = [
            'flash_message'=>'The user'.'&nbsp;'
            .$user->first_name.'&nbsp;'.$user->last_name
            .'&nbsp;'.'was successfully deleted'
        ];

        return back()->with($message);
    }
}
