<?php

namespace App\Controller;

use App\Entity\Moyentp;
use App\Form\MoyentpType;
use App\Repository\MoyentpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/moyentp')]
class MoyentpController extends AbstractController
{
    #[Route('/', name: 'app_moyentp_index', methods: ['GET'])]
    public function index(MoyentpRepository $moyentpRepository): Response
    {
        return $this->render('moyentp/index.html.twig', [
            'moyentps' => $moyentpRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_moyentp_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $moyentp = new Moyentp();
        $form = $this->createForm(MoyentpType::class, $moyentp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moyentp);
            $entityManager->flush();
    
            $this->addFlash('success', 'Ajout avec succès');

            return $this->redirectToRoute('app_moyentp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyentp/new.html.twig', [
            'moyentp' => $moyentp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_moyentp_show', methods: ['GET'])]
    public function show($id): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $repositoryMoy = $em->getRepository(Moyentp::class);
        $moyentps = $repositoryMoy->find($id);
        return $this->render('moyentp/show.html.twig', [
            'moyentps' => $moyentps,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_moyentp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Moyentp $moyentp, MoyentpRepository $moyentpRepository): Response
    {
        $form = $this->createForm(MoyentpType::class, $moyentp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moyentpRepository->save($moyentp, true);
            $this->addFlash('success', 'Mise à jour effectuée avec succès');

            return $this->redirectToRoute('app_moyentp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyentp/edit.html.twig', [
            'moyentp' => $moyentp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_moyentp_delete', methods: ['POST'])]
    public function delete(Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $repository = $em->getRepository(Moyentp::class);
        $moyentps = $repository->find($request->get('id'));
        $em->remove($moyentps);
        $em->flush();
        $this->addFlash('success', 'Suppresion avec succès');
        return $this->redirectToRoute('app_moyentp_index');
    }

    
    #[Route('/search/matricule', name: 'search_matricule', methods: ['POST'])]
public function searchMatricule(Request $request): JsonResponse
{
    $matricule = $request->request->get('matricule');

    $repository = $this->getDoctrine()->getRepository(Moyentp::class);
    $results = $repository->findBy(['matricule' => $matricule]);

    $responseArray = array();
    foreach ($results as $result) {
        $responseArray[] = array(
            'nom' => $result->getNom(),
            'matricule' => $result->getMatricule(),
            'type' => $result->getType(),
            'nbreplace' => $result->getNbreplace(),
            'prix_ticket' => $result->getPrixTicket(),
            'horaire' => $result->getHoraire(),
        );
    }

    return new JsonResponse($responseArray);
}


}
