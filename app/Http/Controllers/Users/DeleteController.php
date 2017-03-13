<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\User as User;
use App\Models\Users\Admin as Admin;
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
        if (\Auth::user()->can('delete', Admin::class)) {
            $user = User::onlyTrashed()->findOrFail($id);

            //Restore user data
            $user->restore();
            $user->owner->restore();

            $message = [
            'flash_message'=>'The user'.'&nbsp;'
            .$user->owner->first_name.'&nbsp;'.$user->owner->last_name
            .'&nbsp;'.'was successfully restored'
            ];

            return back()->with($message);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the user from data base.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hardDelete($id)
    {
        if (\Auth::user()->can('delete', Admin::class)) {
            $user = User::onlyTrashed()->findOrFail($id);

            //Delete the user
            $user->forceDelete();
            $user->owner->forceDelete();

            $message = [
            'flash_message'=>'The user'.'&nbsp;'
            .$user->owner->first_name.'&nbsp;'.$user->owner->last_name
            .'&nbsp;'.'was successfully deleted'
            ];

            return back()->with($message);
        } else {
            return redirect()->back();
        }
    }
}
