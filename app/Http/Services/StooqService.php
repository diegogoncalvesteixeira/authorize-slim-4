<?php

namespace App\Http\Services;

use App\UserRequest;
use Illuminate\Support\Facades\Mail;
use App\Traits\EmailTrait;

class StooqService
{
    use EmailTrait;

    public function getStock($symbol): array
    {
        $url = "https://stooq.com/q/l/?s=".$symbol."&f=sd2t2ohlcvn&h&e=csv";
        $data = file_get_contents($url);
        $data = explode("\n",$data);
        $data = array_slice($data,1,-1);
        return array_map(function($row){
            $row = explode(",",$row);
            return [
                'symbol' => $row[0] ?? '',
                'date' => $row[1] ?? '',
                'time' => $row[2] ?? '',
                'open' => $row[3] ?? '',
                'high' => $row[4] ?? '',
                'low' => $row[5] ?? '',
                'close' => $row[6] ?? '',
                'volume' => $row[7] ?? '',
                'name' => $row[8] ?? '',
            ];
        },$data);
    }

    public function getRequestedStock($user_id): array
    {
        $user_requests = UserRequest::where('user_id',$user_id)->orderby('id','desc')->get();
        if(!$user_requests)
          return [];

        $stocks = [];
        foreach ($user_requests as $user_request) {
          $requested_stock = collect(json_decode($user_request->request))->toArray();
          $requested_stock_date = date('Y-m-d',strtotime($user_request->created_at)).'T'.date('H:i:s',strtotime($user_request->created_at)).'Z';
          $stocks[] = [
            'date' => $requested_stock_date,
            'name' => $requested_stock['name'],
            'symbol' => $requested_stock['symbol'],
            'open' => $requested_stock['open'],
            'high' => $requested_stock['high'],
            'low' => $requested_stock['low'],
            'close' => $requested_stock['close'],
          ];
        }

        return $stocks;
    }

    public function formatStock($stock): array
    {
      $stock = collect($stock)->first();
      return [
        'name' => $stock['name'],
        'symbol' => $stock['symbol'],
        'open' => $stock['open'],
        'high' => $stock['high'],
        'low' => $stock['low'],
        'close' => $stock['close'],
      ];
    }

    public function saveRequestedStock($stock_json,$user_id){
      UserRequest::create([
        'request' => $stock_json,
        'user_id' => $user_id,
      ]);
    }

    public function notifyUserByEmail($stock_json,$user_name,$user_email){
      if(config('mail.method')=='email'){
        $this->sendEmail($user_name,$user_email,'Stooq API - Stock Requested',$stock_json);
      }elseif(config('mail.method')=='rabbitmq'){
        $this->sendEmailWithRabbitMQ($user_name,$user_email,'Stooq API - Stock Requested',['stock_json' => $stock_json,],'emails.stock-requested');
      }
    }

}