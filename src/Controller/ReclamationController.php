<?php

namespace App\Controller;


use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;




#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET', 'POST'])]
    public function index( Request $request , ReclamationRepository $reclamationRepository , PaginatorInterface $paginator ): Response
    {
        $reclamation = $reclamationRepository->findAll() ;

        $back = null;
        $SortKey = $request->request->get('optionsRadios');
        
        if($SortKey){
            switch ($SortKey){
                case 'message':
                    $reclamation = $reclamationRepository->SortBymessage();
                    break;
    
                case 'category':
                    $reclamation = $reclamationRepository->SortBycategory();
                    break;
    
                default:
                    $reclamation = $reclamationRepository->findAll();
            }
        } 


        $pagination = $paginator->paginate(
            $reclamation, /* query NOT result */
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $pagination ,
        ]);
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/reclamation/recherche', name: 'app_reclamation_recherche')]
    public function recherche(Request $request , PaginatorInterface $paginator )
    {
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);

        $category = $request->query->get('category');

        if ($category) {
            $reclamations = $repository->findBy(['category' => $category]);
        } else {
            $reclamations = $repository->findAll();
            
        }
        $reclamations = $paginator->paginate(
            $reclamations, /* query NOT result */
            $request->query->getInt('page', 1),
            4
        );


        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }



// #[Route('/makepdf', name: 'app-make-pdf', methods: ['GET','POST'])]
//     public function makepdf(  Request $request, ReclamationRepository $reclamationRepository, Dompdf $dompdf): Response
//     {
//         $reclamations=$reclamationRepository->findAll();
//             $html = $this->renderView('reclamation/pdf.html.twig', [
//                 'reclamations' => $reclamations,
//             ]);

//             // Generate the PDF using Dompdf
//             $dompdf->loadHtml($html);
//             $dompdf->setPaper('A4', 'portrait');
//             $dompdf->render();

//             // Return the PDF as a response
//             return new Response(
//                 $dompdf->output(),
//                 200,
//                 [
//                     'Content-Type' => 'application/pdf',
//                     'Content-Disposition' => 'inline; filename="document.pdf"',
//                 ]
//             );
        
//     }
}


