<?php

namespace App\Controller;
use App\Entity\Trajet;
use App\Form\SearchTrajetType;
use App\Form\SearchTrajetByDepartAndDestinationType;
use App\Form\TrajetType;
use DateTime;
use App\Repository\TrajetRepository;
use App\Repository\LigneTransportRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{

    #--------------------------------------ADMIN---------------------------------------------#
    #[Route('/trajet/list', name: 'app_trajet_list')]
    public function list(TrajetRepository $repository, Request $request): Response {
        $trajets= $repository->findAll();
        $form=$this->createForm(SearchTrajetType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() ){
            $trajets = $repository->findByDepartOrDestination($form['field']->getData());
            return $this->renderForm('admin/trajet/list.html.twig', [
                'searchForm' => $form,
                'pageName' => 'Liste des Trajets',
                'trajets'=> $trajets
            ]);

        }
        return $this->renderForm('admin/trajet/list.html.twig', [
            'searchForm' => $form,
            'pageName' => 'Liste des Trajets',
            'trajets'=> $trajets
        ]);
    }

    #[Route('/trajet/create', name: 'app_trajet_create')]
    public function create(ManagerRegistry $doctrine, Request $request): Response {
        $display='none';
        $trajet = new Trajet();
        $trajet->setViews(0);
        date_default_timezone_set('Africa/Tunis');
        $trajet->setDateCreation(new DateTime());
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
             
            $rep = $doctrine->getRepository(Trajet::class);
            $t = $rep->findByDepartAndDestination($form['depart']->getData(), $form['destination']->getData());
            if($t == null){
                $em = $doctrine->getManager();
                $em->persist($trajet);
                $em->flush();
                return $this->redirectToRoute('app_trajet_list');
            }else{
                $display='';
                return $this->render('admin/trajet/create.html.twig', [
                    'pageName' => 'Creation d\'un Trajet',
                    "form"=>$form->createView(),
                    "display"=>$display
                ]);
            }   
            
        }
        
        return $this->render('admin/trajet/create.html.twig', [
            'pageName' => 'Creation d\'un Trajet',
            "form"=>$form->createView(),
            "display"=>$display
        ]);
    }

    #[Route('/trajet/read/{id}', name: 'app_trajet_read')]
    public function read($id, TrajetRepository $repository): Response {
        $trajet= $repository->find($id);
        return $this->render('admin/trajet/read.html.twig', [
            'pageName' => 'Trajet / '.$trajet->getDepart()." - ".$trajet->getDestination(),
            'trajet'=> $trajet
        ]);
    }

    #[Route('/trajet/update/{id}', name: 'app_trajet_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request): Response {
        $repository = $doctrine->getRepository(Trajet::class); 
        $trajet= $repository->find($id);
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($trajet);
            $em->flush();
            return $this->redirectToRoute("app_trajet_list");

        }

        return $this->renderForm('admin/trajet/update.html.twig', [
            'pageName' => 'Modification d\'un Trajet',
            'trajet'=> $trajet,
            "form" => $form
        ]);
    }

    #[Route('/trajet/delete/{id}', name: 'app_trajet_delete')]
    public function delete($id, ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Trajet::class);
        $trajet = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($trajet);
        $em->flush();
        return $this->redirectToRoute('app_trajet_list');
    }

    #--------------------------------------USER---------------------------------------------#

    #[Route('/trajet/search', name: 'app_trajet_search')]
    public function search(ManagerRegistry $doctrine, Request $request): Response {
        $display = 'none';
        $form = $this->createForm(SearchTrajetByDepartAndDestinationType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $display = 'none';
            $rep = $doctrine->getRepository(Trajet::class);
            $trajet = $rep->findByDepartAndDestination($form['depart']->getData(), $form['destination']->getData());
            if($trajet != null){
                return $this->redirectToRoute('app_trajet_details', ['id' => $trajet->getId()]);
            }else{
                $display = '';
                return $this->render('user/trajet/search.html.twig', [
                    "form"=>$form->createView(),
                    "display" => $display
                ]);
            }   
        }      
        return $this->render('user/trajet/search.html.twig', [
            "form"=>$form->createView(),
            "display" => $display
        ]);
    }

    #[Route('/trajet/details/{id}', name: 'app_trajet_details')]
    public function details($id, TrajetRepository $trajetRep, LigneTransportRepository $ligneTransportRep, ManagerRegistry $doctrine): Response {
        $ligneTransports = $ligneTransportRep->findByIdTrajet($id);
        $trajet= $trajetRep->find($id);
        if($trajet){
            $trajet->setViews($trajet->getViews()+1);
            $em = $doctrine->getManager();
            $em->flush();
        }
        return $this->render('user/trajet/details.html.twig', [
            'ligneTransports'=> $ligneTransports,
            'trajet'=> $trajet
        ]);
    }


}
