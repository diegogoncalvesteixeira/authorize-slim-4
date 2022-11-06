<?php

namespace App\Http\Controllers;

use App\Http\Services\StooqService;
use App\Traits\HelperTrait;

class StooqController
{
  use HelperTrait;

  private StooqService $StooqService;

  public function __construct()
  {
    $this->StooqService = new StooqService();
  }

  public function getStock($request,$response)
  {
    //validate request
    if(!isset($_GET['q'])){
      $response->getBody()->write(json_encode(['error'=>'No stock name, please provide a stock name as a query string "q"']));
      return $response;
    }

    //validate sql injection
    $stock_code = $this->escape($_GET['q']);

    //get the stock data
    $stock = $this->StooqService->getStock($stock_code);
    $stock = $this->StooqService->formatStock($stock);

    //get the infos from user session
    $user_infos = $request->getAttribute('user_infos');

    //I could do the event dispatching in the service to handle the rest, but i prefer to do it here
    //event()->fire(StockRequestedEvent::class,[$stock,$user_id]);

    //save the stock data log requested
    $this->StooqService->saveRequestedStock(json_encode($stock),$user_infos['user_id']);

    //notify the user by email with the request
    $this->StooqService->notifyUserByEmail(json_encode($stock),$user_infos['user_name'],$user_infos['user_email']);

    //return the stock data
    $response->getBody()->write(json_encode($stock));

    return $response;
  }

  public function getHistory($request,$response)
  {
    //get the infos from user session
    $user_infos = $request->getAttribute('user_infos');

    //get the stock data log requested
    $stock = $this->StooqService->getRequestedStock($user_infos['user_id']);

    //return the stock data
    $response->getBody()->write(json_encode($stock));

    return $response;
  }
}