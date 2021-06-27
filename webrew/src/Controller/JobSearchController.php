<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\AuthPoleEmploie;

class JobSearchController extends AbstractController
{
    private $poleEmploieClient;

    private $poleEmploieId;

   public function  __construct($poleEmploieClient, $poleEmploieId, HttpClientInterface $client) {
       $this->poleEmploieClient = $poleEmploieClient;
       $this->poleEmploieId = $poleEmploieId;
       $this->client = $client;
   }

    #[Route('/job/search', name: 'job_search')]
    public function index(AuthPoleEmploie $auth): Response
    {
       $auth->authentification();

        return $this->render('job_search/index.html.twig', [
            'controller_name' => 'JobSearchController',
        ]);
    }

    #[Route('/job', name:'job')]
    public function job() : array
    {
        $response = $this->client->request(
            'GET',
            "https://api.emploi-store.fr/partenaire/offresdemploi/v2/offres/search"
        ); 

        return $response->toAraay();

        
    }
}
