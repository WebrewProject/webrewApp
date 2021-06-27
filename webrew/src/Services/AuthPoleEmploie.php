<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthPoleEmploie {

    private $poleEmploieClient;

    private $poleEmploieId;
    
    private $client;

   public function  __construct($poleEmploieClient, $poleEmploieId, HttpClientInterface $client) {
       $this->poleEmploieClient = $poleEmploieClient;
       $this->poleEmploieId = $poleEmploieId;
       $this->client = $client;
   }

   public function authentification() : ResponseInterface {
    $response = $this->client->request('POST', 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=%2Fpartenaire', [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],

        'body' => [
            'grant_type' => 'client_credentials',
            '&client_id' => $this->poleEmploieClient,
            '&client_secret' => $this->poleEmploieId,
            '&scope' => "application_$this->poleEmploieClient%20webrew"
        ],
    ]);

  dd(($response));

    return ($response); 
   }
}