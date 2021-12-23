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

   public function authentification() {

    $response = $this->client->request('POST', 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=%2Fpartenaire', [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],

        'body' => [
            'grant_type' => 'client_credentials',
            'client_id' => 'PAR_webrew_7f3535c409c69882be60667192a9a7fed27623306a060055c0fdbace68e2079c',
            'client_secret' => '49768d6d43db30a75ce34e9d5ec115405b631aac0707633e6af41ba87ec82145',
            'scope' => 'api_offresdemploiv2 application_PAR_webrew_7f3535c409c69882be60667192a9a7fed27623306a060055c0fdbace68e2079c o2dsoffre'
        ],
    ]);

    return $response->getContent();
   }
}