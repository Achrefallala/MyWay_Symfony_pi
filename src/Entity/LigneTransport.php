<?php

namespace App\Entity;

use App\Repository\LigneTransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneTransportRepository::class)]
class LigneTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajet = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MoyenTransport $moyenTransport = null;

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

    public function getMoyenTransport(): ?MoyenTransport
    {
        return $this->moyenTransport;
    }

    public function setMoyenTransport(?MoyenTransport $moyenTransport): self
    {
        $this->moyenTransport = $moyenTransport;

        return $this;
    }
}
