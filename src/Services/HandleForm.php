<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HandleForm {


    public function __construct(HttpClientInterface $client)
    {
            $this->client = $client;
    }

    public function getCity() {
        $response = $this->client->request(
            'GET',
            "https://geo.api.gouv.fr/departements/01/communes",
        ); 
        return $response->getContent();
    }
}
