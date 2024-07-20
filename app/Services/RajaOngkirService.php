<?php

namespace App\Services;

use GuzzleHttp\Client;

class RajaOngkirService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('RAJAONGKIR_API_KEY');
    }

    public function getCityList()
    {
        $response = $this->client->get('https://api.rajaongkir.com/starter/city', [
            'headers' => [
                'key' => $this->apiKey,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        $response = $this->client->post('https://api.rajaongkir.com/starter/cost', [
            'headers' => [
                'key' => $this->apiKey,
            ],
            'form_params' => [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
