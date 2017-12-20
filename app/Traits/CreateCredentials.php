<?php

namespace App\Traits;

use App\Models\Communities\Community as Community;

trait CreateCredentials
{
    /**
     * Create user login.
     *
     * @param int $community_id
     * @return string
     */
    public function createLogin($community_id)
    {
        $community = Community::find($community_id);

        //The login is community_id+number in the community
        $number = $community->users->last()->id+1;

        return $community_id.$number;
    }

    /**
     * Create user password.
     *
     * @param int $length
     * @return string
     */
    public function createPassword($length)
    {
        $chars = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ23456789';
        $count = mb_strlen($chars);

        $result = '';
        
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}
