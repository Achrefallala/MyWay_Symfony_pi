<?php

namespace App\Controller;

use App\Form\EtablissementType;
use App\Form\FilterEtablissementType;
use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use App\Form\SortEtablissementType;

use Symfony\Component\String\Slugger\SluggerInterface;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EtablissementController extends AbstractController
{
    #[Route('/etablissement/list', name: 'app_etablissement_list')]
    public function list(EtablissementRepository $repository, Request $request): Response {  
        $etablissements = $repository->findAll();
        $form = $this->createForm(FilterEtablissementType::class);

        date_default_timezone_set('Africa/Tunis');
        $form['maxDateCreation']->setData(new DateTime());

        $sortForm = $this->createForm(SortEtablissementType::class);
        $sortForm['trierPar']->setData('nom');
        $sortForm['type']->setData('ASC');
       
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            if(! $form['depart']->getData() && $form['destination']->getData()){
                $etablissements = $repository->filter($form['type']->getData(), $form['adresse']->getData(), null, $form['destination']->getData()->getDestination(), $form['minViews']->getData(), $form['maxViews']->getData(), $form['minDateCreation']->getData(), $form['maxDateCreation']->getData());
            }
            if(! $form['destination']->getData() && $form['depart']->getData()){
                $etablissements = $repository->filter($form['type']->getData(), $form['adresse']->getData(), $form['depart']->getData()->getDepart(), null, $form['minViews']->getData(), $form['maxViews']->getData(), $form['minDateCreation']->getData(), $form['maxDateCreation']->getData());
            }

            if(! $form['destination']->getData() && ! $form['depart']->getData()){
                $etablissements = $repository->filter($form['type']->getData(), $form['adresse']->getData(), null, null, $form['minViews']->getData(), $form['maxViews']->getData(), $form['minDateCreation']->getData(), $form['maxDateCreation']->getData());
            }

            if($form['destination']->getData() && $form['depart']->getData()){
                $etablissements = $repository->filter($form['type']->getData(), $form['adresse']->getData(), $form['depart']->getData()->getDepart(), $form['destination']->getData()->getDestination(), $form['minViews']->getData(), $form['maxViews']->getData(), $form['minDateCreation']->getData(), $form['maxDateCreation']->getData());
            }
    
            
            return $this->render('admin/etablissement/list.html.twig', [  
                'pageName' => 'Liste des etablissements',  
                'filterForm' => $form->createView(),
                'sortForm' => $sortForm->createView(),
                'etablissements' =>  $etablissements,
                'filtred' => true
            ]);

        }

        $sortForm->handleRequest($request);
        if ($sortForm->isSubmitted()) {
            
            $etablissements = $repository->sort($sortForm['trierPar']->getData(), $sortForm['type']->getData());
            return $this->render('admin/etablissement/list.html.twig', [  
                'pageName' => 'Liste des etablissements',  
                'filterForm' => $form->createView(),
                'sortForm' => $sortForm->createView(),
                'etablissements' =>  $etablissements,
                'filtred' => true
            ]);
        }
        
        return $this->render('admin/etablissement/list.html.twig', [  
            'pageName' => 'Liste des etablissements',  
            'filterForm' => $form->createView(),
            'sortForm' => $sortForm->createView(),
            'etablissements' =>  $etablissements,
            'filtred' => false
        ]);
    }

    #[Route('/etablissement/create', name: 'app_etablissement_create')]
    public function create(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {

        $display = 'none';
        $etablissement = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $etablissement->setViews(0);
        date_default_timezone_set('Africa/Tunis');
        $etablissement->setDateCreation(new DateTime());
        $etablissement->setImage(null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $rep = $doctrine->getRepository(Etablissement::class);
            $etab = $rep->findOneBy(['adresse' => $form['adresse']->getData()]);
            if ($etab == null) {

                $imageFile = $form['imageFile']->getData();
                if($imageFile){
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
        
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/assets/admin/imgEtablissement',
                        $newFilename
                    );
        
                    $etablissement->setImage($newFilename);
                }
                

                $em = $doctrine->getManager();
                $em->persist($etablissement);
                $em->flush();
                
                return $this->redirectToRoute('app_etablissement_list');
            } else {
                $display = '';
                return $this->renderForm('admin/etablissement/create.html.twig', [
                    'pageName' => 'Creation d\'un Etablissement',
                    "form" => $form,
                    "display" => $display
                ]);

            }


        }

        return $this->renderForm('admin/etablissement/create.html.twig', [
            'pageName' => 'Creation d\'un Etablissement',
            "form" => $form,
            "display" => $display
        ]);
    }

    #[Route('/etablissement/read/{id}', name: 'app_etablissement_read')]
    public function read($id, EtablissementRepository $repository): Response
    {
        $etablissement = $repository->find($id);
        

        return $this->render('admin/etablissement/read.html.twig', [
            'pageName' => 'Etablissement / ' . $etablissement->getNom(),
            'etablissement' => $etablissement
        ]);
    }

    #[Route('/etablissement/update/{id}', name: 'app_etablissement_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {

        $repository = $doctrine->getRepository(Etablissement::class);
        $etablissement = $repository->find($id);
        $form = $this->createForm(EtablissementType::class, $etablissement);
        //$path = $this->getParameter('kernel.project_dir') . '\public\assets\admin\imgEtablissement/' . $etablissement->getImage();
        //$file = new File($path);
        //$form['imageFile']->setData($file);
        //$form['imageFile']->setData($this->file($this->getParameter('kernel.project_dir') . '\public\assets\admin\imgEtablissement/' . $etablissement->getImage()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form['imageFile']->getData();
            if($imageFile){
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
    
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/assets/admin/imgEtablissement',
                    $newFilename
                );
    
                $etablissement->setImage($newFilename);
            }
            

            $em = $doctrine->getManager();
            $em->persist($etablissement);
            $em->flush();
            
            return $this->redirectToRoute('app_etablissement_read', ['id' => $id]);


        }

        return $this->render('admin/etablissement/update.html.twig', [
            'pageName' => 'Modification d\'un etablissement',
            'etablissement' => $etablissement,
            "form" => $form->createView()
        ]);
    }

    #[Route('/etablissement/delete/{id}', name: 'app_etablissement_delete')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Etablissement::class);
        $etablissement = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($etablissement);
        $em->flush();
        return $this->redirectToRoute('app_etablissement_list');
    }

    #-----------------------------USER-------------------------#

    #[Route('/etablissement/details/{id}', name: 'app_etablissement_details')]
    public function details($id, EtablissementRepository $repository, ManagerRegistry $doctrine): Response
    {
        $etablissement = $repository->find($id);
        if($etablissement){
            $etablissement->setViews($etablissement->getViews()+1);
            $em = $doctrine->getManager();
            $em->flush();
        }
        return $this->render('user/etablissement/details.html.twig', [
            'pageName' => 'Etablissement / ' . $etablissement->getNom(),
            'etablissement' => $etablissement
        ]);
    }


    function write_to_console($data)
    {
        $console = $data;
        if (is_array($console))
            $console = implode(',', $console);

        echo "<script>console.log('Console: " . $console . "' );</script>";
    }



}