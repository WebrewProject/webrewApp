<?php
namespace App\Services;

use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HandleToken {

    public function  __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    public function generateToken() {

        $token = $this->client->request('POST', 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=%2Fpartenaire', [
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

        return $token;
    }

    public function saveToken($token): int {

        $dataToken = json_decode($token->getContent(), true);
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Paris'));
        $time =  $date->format('H:i:s');
        $expireIn = gmdate("H:i:s" , $dataToken['expires_in']);
        $expire = strtotime($time) + strtotime($expireIn) - strtotime('00:00:00');
        $expire = date('H:i:s', $expire);
        $dataToken["expire"] = $expire;

        if (!file_exists("../data/poleEmploieToken.json")) {
            file_put_contents("../data/poleEmploieToken.json", json_encode($dataToken));
            return 1;
        } else {
            return -1;
        }
    }

    public function checkToken(): int {

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Paris'));
        $time =  $now->format('H:i:s');

        try {
            $token = file_get_contents("../data/poleEmploieToken.json");
            $data = json_decode($token);
        } catch(Exception $e) {
            return $e->getMessage();
        }   

        if (empty($data->access_token) OR $data->access_token == null)
            throw new Exception("No token found.");
        
        if (empty($data->scope) OR $data->scope == null)
            throw new Exception("No scope found.");
        
       if ($data->expire < $time) {
          unlink("../data/poleEmploieToken.json");
          $this->saveToken($this->generateToken());
       }

       return 1;
    }

    public function getToken() {

        if (file_exists("../data/poleEmploieToken.json")) {
            $this->checkToken();
        } else {
            $this->saveToken($this->generateToken());
        }
        $fileToken = file_get_contents("../data/poleEmploieToken.json");
        $token = json_decode($fileToken);

        return $token;
    }
      
}