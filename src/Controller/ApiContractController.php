<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Repository\ContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/contrat')]
class ApiContractController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'app_api_contrat_index', methods: ['GET'])]
    public function index(ContratRepository $contratRepository, SerializerInterface $serializer): JsonResponse
    {
        $contrats = $contratRepository->findAll();
        $json = $serializer->serialize($contrats, 'json', ['circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/{id}', name: 'app_api_contrat_show', methods: ['GET'])]
    public function show($id, ContratRepository $contratRepository, SerializerInterface $serializer): JsonResponse
    {
        $contrat = $contratRepository->find($id);
        $json = $serializer->serialize($contrat, 'json', ['circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/create', name: 'api_contrat_create', methods: ['POST'])]
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
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        // Save the Location entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($location);
        $entityManager->flush();

        // Return a JSON response
        return new JsonResponse(['message' => 'Location created!'], Response::HTTP_CREATED);
    }

    #[Route('/{id}/edit', name: 'api_location_update', methods: ['PUT'])]
    public function update($id, Request $request): JsonResponse
    {
        // Extract the JSON payload from the request
        $jsonData = json_decode($request->getContent(), true);

        // Retrieve the Location entity
        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        // Populate the Location entity with the JSON data
        $form = $this->createForm(LocationType::class, $location);
        $form->submit($jsonData);

        // Validate the form
        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        // Save the Location entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($location);
        $entityManager->flush();

        // Return a JSON response
        return new JsonResponse(['message' => 'Location updated!'], Response::HTTP_OK);
    }

    #[Route('/{id}/delete', name: 'api_location_delete', methods: ['GET'])]
    public function delete(ContratRepository $contratRepository, int $id): JsonResponse
    {
        $contrat = $contratRepository->find($id);
        $contratRepository->remove($contrat, true);

        return new JsonResponse(['message' => 'Location deleted!'], Response::HTTP_OK);
    }
}
