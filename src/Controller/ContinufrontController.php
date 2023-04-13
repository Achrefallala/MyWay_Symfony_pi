<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContinufrontController extends AbstractController
{
    #[Route('/continufront', name: 'app_continufront')]
    public function index(): Response
    {
        return $this->render('continufront/index.html.twig', [
            'controller_name' => 'ContinufrontController',
        ]);
    }
}
