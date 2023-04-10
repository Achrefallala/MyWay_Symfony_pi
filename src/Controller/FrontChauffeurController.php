<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/front')]
class FrontChauffeurController extends AbstractController
{
    #[Route('/chauffeur', name: 'app_front_chauffeur')]
    public function index(Request $request): Response
    {
        $chauffeurs = $this->getDoctrine()->getRepository(Chauffeur::class)->findAll();

        $form = $this->createForm(RatingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $chauffeur = $data['chauffeur'];
            $note = $data['note'];

            // Enregistrer la note dans l'entité Chauffeur
            $chauffeur->setNote($note);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chauffeur);
            $entityManager->flush();

            $this->addFlash('success', 'Votre note a bien été enregistrée !');
        }

        return $this->render('front_chauffeur/index.html.twig', [
            'chauffeurs' => $chauffeurs,
            'form' => $form->createView(),
        ]);
    }
}