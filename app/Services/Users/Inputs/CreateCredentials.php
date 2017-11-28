<?php

namespace App\Services\Users\Inputs;

use App\Models\Users\User as User;

class CreateCredentials
{
    /**
     * Make login which begins with letters and then digits
     * e.g."a12345".
     *
     * @param string $digitQty
     * @param string $letterQty
     *
     * @return string
    */
    public function createLogin($letterQty, $digitQty)
    {
        do {
            $alphabet = 'abcdefghijklmnopqrstuvwxyz';
            $digits = '0123456789';

            $alphaLength = strlen($alphabet) - 1;
            $digitsLenght = strlen($digits) - 1;

            //Get letters
            $letter = "";
            for ($i = 0; $i < $letterQty; $i++) {
                $letter .= substr($alphabet, rand(0, $alphaLength), 1);
            }

            //Get digits
            $digit = "";
            for ($i = 0; $i < $digitQty; $i++) {
                $digit .= strval(rand(0, $digitsLenght));
            }

            $login = $letter.$digit;
        } while (!User::withTrashed()->get()->contains('login', $login));
        
        return $login;
    }

    /**
     * Create random password.
     *
     * @param string $passLenght
     *
     * @return string
    */
    public function createPassword($passLenght)
    {
        $keySpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        $keyLenght = strlen($keySpace) - 1;
        for ($i = 0; $i < $passLenght; $i++) {
            $password .= $keySpace[random_int(0, $keyLenght)];
        }
        return $password;
    }
}
