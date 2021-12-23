<?php

namespace App\Controller;

use App\Services\AuthPoleEmploie;
use App\Services\HandleForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AuthPoleEmploie $auth, Request $request, HandleForm $handleForm): Response
    {   
        if ($_POST) {
            $searchData = explode('&',$request->getContent());
        $result = null;
        $table = [];
        foreach ($searchData as $data) {
            $result[] = explode('=', $data);
        }
        foreach($result as $item) {
         $table[$item[0]] = $item[1];
        }
        if(array_key_exists("submit",  $table)) {
            array_pop($table);
        }
        return $this->redirectToRoute('job', $table);
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
