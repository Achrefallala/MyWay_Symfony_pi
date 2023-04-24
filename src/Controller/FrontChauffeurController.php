<?php
namespace App\Controller;

use App\Entity\Chauffeur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FrontChauffeurController extends AbstractController
{
    #[Route('/front/chauffeur', name: 'app_front_chauffeur', methods:['GET', 'POST'])]
    public function noteChauffeur(Request $request, ManagerRegistry $doctrine): Response
    {
        // Vérifier si le formulaire a été soumis
        if ($request->isMethod('POST')) {
            // Récupérer l'identifiant du chauffeur sélectionné
            $id = $request->request->get('chauffeur');

            // Récupérer la note attribuée
            $note = $request->request->get('note');

            // Récupérer l'entité chauffeur correspondante depuis la base de données
            $chauffeur = $doctrine->getManager()->getRepository(Chauffeur::class)->find($id);

            // Mettre à jour l'attribut note de l'entité chauffeur avec la nouvelle note
            $chauffeur->setNote($note);

            // Enregistrer les modifications dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($chauffeur);
            $entityManager->flush();

            // Rediriger vers une autre page
            return $this->redirectToRoute('app_front_chauffeur');
        }

        // Récupérer tous les chauffeur depuis la base de données
        $chauffeurs = $doctrine->getManager()->getRepository(Chauffeur::class)->findAll();

        // Afficher le formulaire pour saisir la note
        return $this->render('front_chauffeur/index.html.twig', [
            'chauffeurs' => $chauffeurs,
        ]);
    }
}
