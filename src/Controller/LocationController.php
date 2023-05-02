<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Form\SearchLocationFromType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/location')]
class LocationController extends AbstractController
{
    #[Route('/', name: 'app_location_index', methods: ['GET', 'POST'])]
    public function index(LocationRepository $locationRepository, Request $request): Response
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
   


                return $this->render('location/index.html.twig', [
                    'locations' => $locations,
                    'form' => $form->createView(),
                ]);
            }
        } else {
            $locations = $locationRepository->findAll();
        }

        return $this->render('location/index.html.twig', [
            'locations' => $locations,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LocationRepository $locationRepository): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * image upload
             */
            $imageFile = $form->get('image')->getData();
            $originalName = $imageFile->getClientOriginalName();
            $extension = $imageFile->guessExtension();
            $hashedName = password_hash($originalName, PASSWORD_DEFAULT) . '.' . $extension;

            $imageFile->move(
                $this->getParameter('images_directory'),
                $hashedName
            );

            $location->setImage(basename($hashedName));

            /**
             * end image upload
             */
            $locationRepository->save($location, true);

            return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('location/new.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_location_show', methods: ['GET'])]
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_location_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Location $location, LocationRepository $locationRepository): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $imageFile = $form->get('image')->getData();
            $originalName = $imageFile->getClientOriginalName();
            $extension = $imageFile->guessExtension();
            $hashedName = password_hash($originalName, PASSWORD_DEFAULT) . '.' . $extension;

            $imageFile->move(
                $this->getParameter('images_directory'),
                $hashedName
            );

            $location->setImage(basename($hashedName));

            $locationRepository->save($location, true);

            return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('location/edit.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_location_delete', methods: ['POST'])]
    public function delete(Request $request, Location $location, LocationRepository $locationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $location->getId(), $request->request->get('_token'))) {
            $locationRepository->remove($location, true);
        }

        return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/pdf', name: 'app_location_pdf', methods: ['GET', 'POST'])]
    public function createPDF(Location $location): Response
    {
        $tableHtml = '
        <!DOCTYPE html>
 
        <head>
            <meta charset="UTF-8">
            <title>Location Information</title>
            <style>
               table {
				border-collapse: separate;
				border-spacing: 0 15px;
			}
			th {
				background-color: #4287f5;
				color: white;
			}
			th,
			td {
				width: 250px;
				text-align: center;
				border: 1px solid black;
				padding: 5px;
			}
			h2 {
				color: #4287f5;
			}
			span.circle {
				background: #FFB52E;
				border-radius: 50%;
				-moz-border-radius: 50%;
				-webkit-border-radius: 50%;
				color: #6e6e6e;
				display: inline-block;
				font-weight: bold;
				line-height: 40px;
				margin-right: 5px;
				text-align: center;
				width: 150px;
			}
            img{
            margin-left: 15%; }
            </style>
        </head>
        <body>
            <h2>Location Information</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <td>' . $location->getNom() . '</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>' . $location->getType() . '</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>' . $location->getDescription() . '</td>
                </tr>
                <tr>
                    <th>Availability</th>
                    <td>' . ($location->getDisponibilite() ? 'Available' : 'Not Available') . '</td>
                </tr>
                <tr>
                    <th>Contract Price</th>
                    <td>' . $location->getContrat()->getPrix() . ' DT</td>
                </tr>
                <tr>
                    <th>Contract Start Date</th>
                    <td>' . $location->getContrat()->getDateDebut()->format("d/m/Y") . '</td>
                </tr>
                <tr>
                    <th>Contract End Date</th>
                    <td>' . $location->getContrat()->getDateFin()->format("d/m/Y") . '</td>
                </tr>
            </table>

<img src= '. $location->getImage() .' alt="car image" width="200" height="150" >        </body>
        </html>

        ';


        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($tableHtml);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="location.pdf"'
        ]);
    }

    #[Route('/reservation/calendar', name: 'app_location_calendar', methods: ['GET', 'POST'])]
    public function calendar(): Response
    {
        return $this->render("calendar/index.html.twig", []);
    }
}
