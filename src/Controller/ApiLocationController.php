<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/location')]
class ApiLocationController extends AbstractController
{

    private $serializer;


    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'app_api_location_index', methods: ['GET'])]
    public function index(LocationRepository $locationRepository, SerializerInterface $serializer): JsonResponse
    {
        $contrats = $locationRepository->findAll();
        $json = $serializer->serialize($contrats, 'json', ['circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/{id}', name: 'app_api_location_show', methods: ['GET'])]
    public function show($id, LocationRepository $locationRepository, SerializerInterface $serializer): JsonResponse
    {
        $contrat = $locationRepository->find($id);
        $json = $serializer->serialize($contrat, 'json', ['circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/create', name: 'api_location_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        // Extract the JSON payload from the request
        $jsonData = json_decode($request->getContent(), true);

        // Create a new Location entity and populate it with the JSON data
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->submit($jsonData);

        // Validate the form
        if (!$form->isValid()) {
            $errors = [];

            // Loop through the form errors and create an array of error messages
            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getPropertyPath()] = $error->getMessage();
            }

            // Return a JSON response with the form errors
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $errors,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Save the Location entity to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($location);
        $entityManager->flush();

        // Return a JSON response with the newly created Location entity
        return new JsonResponse([
            'status' => 'success',
            'message' => 'Location created successfully',
            'location' => $location,
        ], JsonResponse::HTTP_CREATED);
    }


    #[Route('/{id}/delete', methods: ['GET'])]
    public function delete(LocationRepository $locationRepository, int $id): JsonResponse
    {
        $location = $locationRepository->find($id);
        $locationRepository->remove($location, true);

        return new JsonResponse(['status' => 'Location deleted'], Response::HTTP_OK);
    }
}
