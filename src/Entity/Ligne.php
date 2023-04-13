<?php

namespace App\Entity;

use App\Repository\LigneRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: LigneRepository::class)]
class Ligne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trajet')]
   
    private ?Trajet $trajet = null;

    #[ORM\ManyToOne(inversedBy: 'moyentp')]
    
    private ?Moyentp $moyentp = null;

   
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }

    public function getMoyentp(): ?Moyentp
    {
        return $this->moyentp;
    }

    public function setMoyentp(?Moyentp $moyentp): self
    {
        $this->moyentp = $moyentp;

        return $this;
    }
}
