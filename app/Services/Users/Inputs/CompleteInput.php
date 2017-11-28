<?php

namespace App\Services\Users\Inputs;

use App\Services\Users\Inputs\CreateCredentials as CreateCredentials;
use App\Models\Roles\Role as Role;

class CompleteInput extends CreateCredentials
{
    /**
     * The default role.
     *
     * @var string
     */
    protected $defaultRole = 'respondent';

    /**
     * Complete input by data ommited in the request and store it
     *
     * @param array $input
     * @return App\Models\Users\User
    */
    public function storeUser($input)
    {
        //Add usergroup Id
        $input['user_group_id'] = \Route::input('usergroup')->id;

        //Add community id if it is not in the input
        if (!isset($input['community_id'])) {
            $input['community_id'] = \Auth::user()->community_id;
        }

        //Add role id if it is not in the input
        if (!isset($input['role_id'])) {
            $input['role_id'] = Role::where('role', $this->roleDefault)->firstOrFail()->id;
        }

        //Create and add a login
        $input['login'] = $this->createLogin(1, 5);

        //Create and add a password createPassword(int $passLenght)
        $input['password'] = $this->createPassword(2);

        //Store user data
        $user = User::create($input);

        return $user;
    }

    /**
     * Update users grade
     *
     * @param App\Models\Users\User $user
     * @param array $input
     * @return array
    */
    public function updateUserGrade(User $user, $input)
    {
        //Get student grade
        $grade = Grade::where([
            ['level_id', '=', $input['level_id']],
            ['period_id', '=', $input['period_id']],
            ['stream_id', '=', $input['stream_id']],
        ])->first();
          
        //If grade doesnt exist then create missed grade
        if ($grade == null) {
            $grade = Grade::create($input);
        }

        //Insert the record to the intermediate table.
        $user->grades()->attach($grade->id);
    }

     /**
     * Get grade by attribute Id
     *
     * @param array $input
     * @return App\Models\Users\User
    */
    public function getGradeByAttrId($input)
    {
        $grade = Grade::where([
            ['level_id', '=', $input['level_id']],
            ['period_id', '=', $input['period_id']],
            ['stream_id', '=', $input['stream_id']],
        ])->first();
    }

     /**
     * Get grade by attribute name
     *
     * @param array $input
     * @return App\Models\Users\User
    */
    public function getGradeByAttrName($input)
    {
        //
    }
}
