<?php

namespace App\Traits;

trait CreateCredentials 
{
	/**
    * Make login which begins with letters and then digits 
    * e.g."a12345".
    *
    * @var $digitQty defines digits quantity
    * @var $lettarQty defines letters quantity
    */
    public function createLogin($letterQty, $digitQty) 
	{ 
		$alphabet = 'abcdefghijklmnopqrstuvwxyz';
		$digits = '0123456789';
    	$pass = array(); 

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

    	return $letter.$digit; 
	}


	/**
    * Create random password.
    *
    * @var $passLenght defines password lenght 
    * 
    */
    public function createPassword($passLenght) 
    {
    	

    }
}