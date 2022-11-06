<?php

namespace App\Http\Services;

use App\User;
use App\Support\Auth;
use App\Traits\JWTTrait;
use App\Traits\HelperTrait;

class UserService
{
    use JWTTrait, HelperTrait;

    public function store($name,$email,$password): User
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->save();
        return $user;
    }

    public function getUserByEmail($email): User
    {
        return User::where('email',$email)->first();
    }

    public function countUsersByEmail($email): int
    {
        return User::where('email',$email)->count();
    }

    public function login($email,$password): bool
    {
        return Auth::attempt($email,$this->encrypt($password));
    }

    public function getToken($user_email,$user_id,$user_name): string
    {
      return $this->generate_token($user_email,$user_id,$user_name);
    }

    public function verifyUser($email): bool
    {
      return $this->countUsersByEmail($email) > 0;
    }

}