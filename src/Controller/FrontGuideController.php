<?php
namespace App\Controller;

use App\Entity\Guide;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FrontGuideController extends AbstractController
{
    #[Route('/front/guide', name: 'app_front_guide', methods:['GET', 'POST'])]
    public function noteGuide(Request $request, ManagerRegistry $doctrine): Response
    {
        // Vérifier si le formulaire a été soumis
        if ($request->isMethod('POST')) {
            // Récupérer l'identifiant du guide sélectionné
            $id = $request->request->get('guide');

            // Récupérer la note attribuée
            $note = $request->request->get('note');

            // Récupérer l'entité Guide correspondante depuis la base de données
            $guide = $doctrine->getManager()->getRepository(Guide::class)->find($id);

            // Mettre à jour l'attribut note de l'entité Guide avec la nouvelle note
            $guide->setNote($note);

            // Enregistrer les modifications dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($guide);
            $entityManager->flush();

            // Rediriger vers une autre page
            return $this->redirectToRoute('app_front_guide');
        }

        // Récupérer tous les guides depuis la base de données
        $guides = $doctrine->getManager()->getRepository(Guide::class)->findAll();

        // Afficher le formulaire pour saisir la note
        return $this->render('front_guide/index.html.twig', [
            'guides' => $guides,
        ]);
    }
}
