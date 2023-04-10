<?php

namespace App\Controller;

use App\Entity\Guide;
use App\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/front')]
class FrontGuideController extends AbstractController
{
    
    #[Route('/guide', name: 'app_front_guide', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $guides = $this->getDoctrine()->getRepository(Guide::class)->findAll();

        $form = $this->createForm(RatingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $guide = $data['guide'];
            $note = $data['note'];

            // Enregistrer la note dans l'entité Guide
            $guide->setNote($note);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guide);
            $entityManager->flush();

            $this->addFlash('success', 'Votre note a bien été enregistrée !');
        }

        return $this->render('front_guide/index.html.twig', [
            'guides' => $guides,
            'form' => $form->createView(),
        ]);
    }
}