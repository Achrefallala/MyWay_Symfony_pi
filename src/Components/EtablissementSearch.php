<?php
namespace App\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Repository\EtablissementRepository;


#[AsLiveComponent('EtablissementSearch')]
class EtablissementSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public $etablissements;
    
    public $filtred;

    public function __construct(private EtablissementRepository $etablissementRepository)
    {
        
    }

    public function getListEtablissements(): array
    {
        if($this->filtred == true){
            return $this->etablissements;
        }
        
        return $this->etablissementRepository->findByAnyField($this->query);
    }
    
    
}