<?php

namespace App\Controller;

use App\Entity\Ligne;
use App\Form\Ligne1Type;
use App\Repository\LigneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/ligne')]
class LigneController extends AbstractController
{
    #[Route('/', name: 'app_ligne_index', methods: ['GET'])]
    public function index(LigneRepository $ligneRepository): Response
    {
        return $this->render('ligne/index.html.twig', [
            'lignes' => $ligneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ligne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LigneRepository $ligneRepository): Response
    {
        $ligne = new Ligne();
        $form = $this->createForm(Ligne1Type::class, $ligne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ligneRepository->save($ligne, true);
            
            $this->addFlash('success', 'Ajout avec succès');
            
            return $this->redirectToRoute('app_ligne_index', [], Response::HTTP_SEE_OTHER);
        }
          
        return $this->renderForm('ligne/new.html.twig', [
            'ligne' => $ligne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_show', methods: ['GET'])]
    public function show(Ligne $ligne): Response
    {
        return $this->render('ligne/show.html.twig', [
            'ligne' => $ligne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ligne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ligne $ligne, LigneRepository $ligneRepository): Response
    {
        $form = $this->createForm(Ligne1Type::class, $ligne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ligneRepository->save($ligne, true);
            
            $this->addFlash('success', 'Mise a jour avec succès');

            return $this->redirectToRoute('app_ligne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ligne/edit.html.twig', [
            'ligne' => $ligne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_delete', methods: ['POST'])]
    public function delete(Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $repository = $em->getRepository(Ligne::class);
        $lignes = $repository->find($request->get('id'));
        $em->remove($lignes);
        $em->flush();
        
        $this->addFlash('success', 'Suppresion avec succès');
       
        return $this->redirectToRoute('app_ligne_index');
    }
}
