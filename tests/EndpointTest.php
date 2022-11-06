<?php

declare(strict_types=1);

namespace Tests;

use Faker\Factory as Faker;
use PHPStan\Parallel\Process;

class EndpointTest extends BaseTestCase
{
  //create setup method
  private \Faker\Generator $faker;
  private \GuzzleHttp\Client $client;

  public function setUp(): void
  {
    parent::setUp();

    $this->client = new \GuzzleHttp\Client();
    $this->faker = Faker::create();
  }

  /**
   * @test
   */
  public function UserStoreValid(){
    $url = 'http://localhost:8080/users/store';
    $data = [
      'password' => $this->faker->password,
      'email' => $this->faker->email,
      'name' => $this->faker->name,
    ];

    //create a post request with guzzle
    $response = $this->client->request('POST', $url, ['form_params' => $data]);
    $response_data = $response->getBody()->getContents();

    //check if the response is a json
    $this->assertJson($response_data);

    //asssert json contains the key 'name'
    $this->assertArrayHasKey('name', json_decode($response_data, true));

    //asssert json contains the key 'email'
    $this->assertArrayHasKey('email', json_decode($response_data, true));
  }

  /**
   * @test
   */
  public function UserStoreEndInvalid(){
    $url = 'http://localhost:8080/users/store';
    $data = [
    'password' => $this->faker->password,
    'name' => $this->faker->name,
    ];

    //create a post request with guzzle
    $response = $this->client->request('POST', $url, ['form_params' => $data]);
    $response_data = $response->getBody()->getContents();

    //check if the response is a json
    $this->assertJson($response_data);

    //asssert json contains the key 'name'
    $this->assertArrayNotHasKey('name', json_decode($response_data, true));

    //asssert json contains the key 'email'
    $this->assertArrayNotHasKey('email', json_decode($response_data, true));
  }

  /**
   * @test
   */
  public function UserTokenEndpointValid(){
    //first we create the user
    $url = 'http://localhost:8080/users/store';
    $data = [
    'password' => $this->faker->password,
    'email' => $this->faker->email,
    'name' => $this->faker->name,
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data]);
    $response_data = $response->getBody()->getContents();

    //now we get the token
    $url = 'http://localhost:8080/users/token';
    $data_token = [
      'password' => $data['password'],
      'email' => $data['email'],
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data_token]);
    $response_data = $response->getBody()->getContents();
    self::assertIsString($response_data);
  }

  /**
   * @test
   */
  public function UserTokenEndpointInvalid(){
    //first we create the user
    $url = 'http://localhost:8080/users/store';
    $data = [
      'password' => $this->faker->password,
      'email' => $this->faker->email,
      'name' => $this->faker->name,
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data]);
    $response->getBody()->getContents();

    //now we get the token
    $url = 'http://localhost:8080/users/token';
    $data_token = [
      'password' => 'invalid_password',
      'email' => $data['email'],
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data_token]);
    $response_data = $response->getBody()->getContents();

    //check if the response is a json
    $this->assertJson($response_data);

    //asser json contains the key 'error'
    $this->assertArrayHasKey('Error', json_decode($response_data, true));
  }

  /**
   * @test
   */
  public function StockEndpointValid(){
    //first we create the user
    $url = 'http://localhost:8080/users/store';
    $data = [
    'password' => $this->faker->password,
    'email' => $this->faker->email,
    'name' => $this->faker->name,
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data]);
    $response_data = $response->getBody()->getContents();

    //now we get the token
    $url = 'http://localhost:8080/users/token';
    $data_token = [
      'password' => $data['password'],
      'email' => $data['email'],
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data_token]);
    $json_token = $response->getBody()->getContents();
    $json_token = str_replace('"', '', $json_token);

    //make a request using token bearer
    $url = 'http://localhost:8080/stock?q=aapl.us';
    $response = $this->client->request('GET', $url, [
      'headers' => [
        'Authorization' => 'Bearer '.$json_token,
      ],
    ]);
    $response_data = $response->getBody()->getContents();

    //check if the response is a json
    $this->assertJson($response_data);

    //assert json contains the key 'name'
    $this->assertArrayHasKey('name', json_decode($response_data, true));

    //assert json contains the key 'symbol'
    $this->assertArrayHasKey('symbol', json_decode($response_data, true));

    //assert json contains the key 'open'
    $this->assertArrayHasKey('open', json_decode($response_data, true));

    //assert json contains the key 'high'
    $this->assertArrayHasKey('high', json_decode($response_data, true));

    //assert json contains the key 'low'
    $this->assertArrayHasKey('low', json_decode($response_data, true));

    //assert json contains the key 'close'
    $this->assertArrayHasKey('close', json_decode($response_data, true));
  }

  /**
   * @test
   */
  public function StockEndpointInvalid(){
    //first we create the user
    $url = 'http://localhost:8080/users/store';
    $data = [
    'password' => $this->faker->password,
    'email' => $this->faker->email,
    'name' => $this->faker->name,
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data]);
    $response_data = $response->getBody()->getContents();

    //now we get the token
    $url = 'http://localhost:8080/users/token';
    $data_token = [
    'password' => $data['password'],
    'email' => $data['email'],
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data_token]);
    $json_token = $response->getBody()->getContents();
    $json_token = 'invalid';

    //make a request using token bearer
    $url = 'http://localhost:8080/stock?q=aapl.us';
    $response = $this->client->request('GET', $url, [
    'headers' => [
    'Authorization' => 'Bearer '.$json_token,
    ],
    ]);
    $response_data = $response->getBody()->getContents();

    //check if the response is a json
    $this->assertJson($response_data);

    //assert json contains the key 'error'
    $this->assertArrayHasKey('Error', json_decode($response_data, true));
  }

  /**
   * @test
   */
  public function HistoryEndpointValid(){
    //first we create the user
    $url = 'http://localhost:8080/users/store';
    $data = [
    'password' => $this->faker->password,
    'email' => $this->faker->email,
    'name' => $this->faker->name,
    ];

    $this->client->request('POST', $url, ['form_params' => $data]);

    //now we get the token
    $url = 'http://localhost:8080/users/token';
    $data_token = [
    'password' => $data['password'],
    'email' => $data['email'],
    ];

    $response = $this->client->request('POST', $url, ['form_params' => $data_token]);
    $json_token = $response->getBody()->getContents();
    $json_token = str_replace('"', '', $json_token);

    //lets make 2 requests to populate de database
    $url = 'http://localhost:8080/stock?q=aapl.us';
    $this->client->request('GET', $url, [
      'headers' => [
        'Authorization' => 'Bearer '.$json_token,
      ],
    ]);
    $url = 'http://localhost:8080/stock?q=test';
    $this->client->request('GET', $url, [
    'headers' => [
    'Authorization' => 'Bearer '.$json_token,
    ],
    ]);

    //make a request using token bearer
    $url = 'http://localhost:8080/history';
    $response = $this->client->request('GET', $url, [
    'headers' => [
    'Authorization' => 'Bearer '.$json_token,
    ],
    ]);
    $response_data = $response->getBody()->getContents();

    //check if the response is a json
    $this->assertJson($response_data);

    //assert json contains the key 'name'
    $this->assertArrayHasKey('name', json_decode($response_data, true)[0]);

    //assert json contains the key 'symbol'
    $this->assertArrayHasKey('symbol', json_decode($response_data, true)[0]);

    //assert json contains the key 'open'
    $this->assertArrayHasKey('open', json_decode($response_data, true)[0]);

    //assert json contains the key 'high'
    $this->assertArrayHasKey('high', json_decode($response_data, true)[0]);

    //assert json contains the key 'low'
    $this->assertArrayHasKey('low', json_decode($response_data, true)[0]);

    //assert json contains the key 'close'
    $this->assertArrayHasKey('close', json_decode($response_data, true)[0]);

    //assert json contains the key 'date'
    $this->assertArrayHasKey('date', json_decode($response_data, true)[0]);
  }

  /**
   * @test
   */
  public function HistoryEndpointInvalid(){
    //first we create the user
    $url = 'http://localhost:8080/users/store';
    $data = [
    'password' => $this->faker->password,
    'email' => $this->faker->email,
    'name' => $this->faker->name,
    ];

    $this->client->request('POST', $url, ['form_params' => $data]);

    //now we get the token
    $url = 'http://localhost:8080/users/token';
    $data_token = [
    'password' => $data['password'],
    'email' => $data['email'],
    ];

    //define invalid token
    $json_token = 'invalid';

    //make a request using token bearer
    $url = 'http://localhost:8080/history';
    $response = $this->client->request('GET', $url, [
      'headers' => [
      'Authorization' => 'Bearer '.$json_token,
    ],
    ]);
    $response_data = $response->getBody()->getContents();

    //check if the response is a json
    $this->assertJson($response_data);

    //assert json contains the key 'error'
    $this->assertArrayHasKey('Error', json_decode($response_data, true));
  }
}