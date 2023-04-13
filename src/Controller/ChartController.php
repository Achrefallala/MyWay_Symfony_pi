<?php

namespace App\Controller;

use App\Entity\Moyentp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\MoyentpRepository;

use Doctrine\ORM\EntityManagerInterface;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'chart')]
    public function index( MoyentpRepository $moyentpRepository) 
    {
        
        $nb_bus = $moyentpRepository->getNbBus();
    $nb_metro = $moyentpRepository->getNbMetro();
    $nb_train = $moyentpRepository->getNbTrain();

    return $this->render('chart/index.html.twig', [
        'nb_bus' => $nb_bus,
        'nb_metro' => $nb_metro,
        'nb_train' => $nb_train,
    ]);
   
        
    
    } 

   
    
}
