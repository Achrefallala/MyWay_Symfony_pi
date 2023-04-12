<?php
namespace App\Controller;

use App\Entity\Chauffeur;
use App\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontChauffeurController extends AbstractController
{
    #[Route('/front/chauffeur', name: 'app_front_chauffeur', methods:['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $chauffeurs = $entityManager->getRepository(Chauffeur::class)->findAll();

        $form = $this->createForm(RatingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $note = $formData['note'];
            $chauffeur = $formData['chauffeur'];

            $chauffeur->setNote($note);

            $entityManager->persist($chauffeur);
            $entityManager->flush();

            $this->addFlash('success', 'La note a été enregistrée avec succès.');

            return $this->redirectToRoute('app_front_chauffeur');
        }

        return $this->render('front_chauffeur/index.html.twig', [
            'chauffeurs' => $chauffeurs,
            'form' => $form->createView(),
        ]);
    }
}


