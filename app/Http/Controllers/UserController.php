<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\TokenRequest;
use App\Support\Auth;

class UserController
{
  /**
   * @var UserService
   */
  private $UserService;

  public function __construct()
  {
    $this->UserService = new UserService();
  }

  public function store(StoreUserRequest $input,$response)
  {
    //in case it fails on validation, validation errors will be returned, validation is done in the request class
    if ($input->failed()){
      $response->getBody()->write(json_encode(session()->flash()->get('errors')));
      return $response;
    }

    //proceed to store the user
    $name = $input->name;
    $email = $input->email;
    $password = $input->password;

    //call the service to store the user
    $user = $this->UserService->store($name,$email,$password);

    //return the user
    $response->getBody()->write(json_encode($user));

    return $response;
  }

  public function token(TokenRequest $input,$response)
  {
    if ($input->failed()){
      $response->getBody()->write(json_encode(session()->flash()->get('errors')));
      return $response;
    }

    $email = $input->email;
    $password = $input->password;

    //try to login the user
    $successful = $this->UserService->login($email,$password);
    if(!$successful){
      $response->getBody()->write(json_encode(['Error'=>'Invalid credentials']));
      return $response;
    }

    //get the user
    $user_id = Auth::user()->id;
    $user_name = Auth::user()->name;

    //call the service to get the token
    $token = $this->UserService->getToken($email,$user_id,$user_name);

    //return the token
    $response->getBody()->write(json_encode($token));

    return $response;
  }

  public function unauthorized($response)
  {
    $response->getBody()->write(json_encode(['Error'=>'Unauthorized']));
    return $response;
  }
}