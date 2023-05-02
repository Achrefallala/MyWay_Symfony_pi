<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\SearchLocationFromType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/reservation/location')]
class ReservationLocationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_location_index', methods: ['GET', 'POST'])]
    public function index(LocationRepository $locationRepository, Request $request,PaginatorInterface $paginator): Response
    {
    
        $form = $this->createForm(SearchLocationFromType::class);
        $locations = [];

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->get('field_name')->getData();
                if ($data) {
                    $locations = $locationRepository->findByArgument($data);
                } else {
                    $locations = $locationRepository->findAll();
                }
                $locations = $paginator->paginate(
                    $locations,
                    $request->query->getInt('page', 1),
                    3 );
                return $this->render('reservation_location/index.html.twig', [
                    'locations' => $locations,
                    'form' => $form->createView(),
                ]);
            }
        } else {
          $locations= $locationRepository->findBy(['disponibilite' => true]);
            $locations = $paginator->paginate(
                $locations,
                $request->query->getInt('page', 1),
                3 );
    
            return $this->render('reservation_location/index.html.twig', [
                'locations' =>$locations ,
                'form' => $form->createView(),
            ]);
            // return $this->render('reservation_location/index.html.twig', [
            //     'locations' => $locationRepository->findBy(['disponibilite' => true]),
            //     'form' => $form->createView(),
            // ]);
        }

     
    }

    #[Route('/{id}', name: 'app_reservation_update', methods: ['GET', 'POST'])]
    public function show(LocationRepository $locationRepository, Location $location): Response
    {
        $location->setDisponibilite(false);
        $locationRepository->save($location, true);
        return $this->redirectToRoute('app_reservation_location_index', [], Response::HTTP_SEE_OTHER);
    }
}
