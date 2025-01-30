<?php

namespace App\Services;

use Parse\ParseUser;

class UserService
{
    public function createUserInParse(array $data)
    {

        $user = new ParseUser();
        $user->set("username", $data['name']);
        $user->set("email", $data['email']);
        $user->set("password", $data['password']);

        try {
            $user->signUp();
            return $user->getObjectId(); 
        } catch (\Exception $e) {
            return ['error' => $e->getTrace()];
        }
    }
}
