<?php

namespace App\Http\Middleware;

use App\Support\Auth;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handle;
use Slim\Psr7\Response;
use App\Traits\JWTTrait;
use App\Http\Services\UserService;


class JWTMiddleware
{
  use JWTTrait;

  private UserService $UserService;

  public function __construct()
  {
    $this->UserService = new UserService();
  }

  public function __invoke(Request $request, Handle $handler)
  {
    //if has no authorization header
    if(!$request->getHeader('Authorization'))
      return redirect('/unauthorized');

    //get the token
    $token = $request->getHeader('Authorization')[0];

    //decode token
    $user_infos = $this->decode_token($token);
    if(isset($user_infos['error']))
      return redirect('/unauthorized');

    //verify if user exists
    if(!$this->UserService->verifyUser($user_infos["user_email"]))
      return redirect('/unauthorized');

    //send user_infos to the controller
    $request = $request->withAttribute('user_infos',$user_infos);

    return $handler->handle($request);
  }
}
