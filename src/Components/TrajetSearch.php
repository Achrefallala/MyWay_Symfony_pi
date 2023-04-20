<?php
namespace App\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Repository\TrajetRepository;

#[AsLiveComponent('TrajetSearch')]
class TrajetSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private TrajetRepository $trajetRepository)
    {
    }

    public function getTrajets(): array
    {
        // example method that returns an array of Products
        return $this->trajetRepository->findByDepartOrDestination($this->query);
    }
}