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
        $user->set("tenant_id", $data['tenant_id']);

        try {
            $user->signUp();
            return $user->getObjectId(); 
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), 'line'=> $e->getTrace()];
        }
    }
}
