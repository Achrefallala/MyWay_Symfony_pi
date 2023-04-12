<?php
namespace App\Controller;

use App\Entity\Guide;
use App\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontGuideController extends AbstractController
{
    #[Route('/front/guide', name: 'app_front_guide', methods:['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $guides = $entityManager->getRepository(Guide::class)->findAll();

        $form = $this->createForm(RatingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $note = $formData['note'];
            $guide = $formData['guide'];

            $guide->setNote($note);

            $entityManager->persist($guide);
            $entityManager->flush();

            $this->addFlash('success', 'La note a été enregistrée avec succès.');

            return $this->redirectToRoute('app_front_guide');
        }

        return $this->render('front_guide/index.html.twig', [
            'guides' => $guides,
            'form' => $form->createView(),
        ]);
    }
}
