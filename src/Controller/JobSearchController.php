<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\AuthPoleEmploie;
use App\Services\HandleToken;

class JobSearchController extends AbstractController
{
    private $poleEmploieClient;
    private $poleEmploieId;
    private $authPoleEmploie;

   public function  __construct($poleEmploieClient, $poleEmploieId, HttpClientInterface $client, AuthPoleEmploie $authPoleEmploie) {
       $this->poleEmploieClient = $poleEmploieClient;
       $this->poleEmploieId = $poleEmploieId;
       $this->client = $client;
       $this->authPoleEmploie = $authPoleEmploie->authentification();
   }

    #[Route('/job/search', name: 'job_search')]
    public function index(AuthPoleEmploie $auth): Response
    {
    
        return $this->render('job_search/index.html.twig', [
            'controller_name' => 'JobSearchController',
        ]);
    }

    #[Route('/job', name:'job')]
    public function job(HandleToken $handleToken) : array
    {
        $token = $handleToken->getToken();

        $response = $this->client->request(
            'GET',
            "https://api.emploi-store.fr/partenaire/offresdemploi/v2/offres/search",
            [
                'headers' => [
                    'Authorization' => "Bearer $token->access_token"
                ]
            ]
        ); 
        dd($response->toArray()); 
    }
}
