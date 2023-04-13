<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $depart = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $directions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'trajet', targetEntity: Ligne::class)]
    private Collection $trajet;

    public function __construct()
    {
        $this->trajet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDirections(): ?string
    {
        return $this->directions;
    }

    public function setDirections(?string $directions): self
    {
        $this->directions = $directions;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Ligne>
     */
    public function getTrajet(): Collection
    {
        return $this->trajet;
    }

    public function addTrajet(Ligne $trajet): self
    {
        if (!$this->trajet->contains($trajet)) {
            $this->trajet->add($trajet);
            $trajet->setTrajet($this);
        }

        return $this;
    }

    public function removeTrajet(Ligne $trajet): self
    {
        if ($this->trajet->removeElement($trajet)) {
            // set the owning side to null (unless already changed)
            if ($trajet->getTrajet() === $this) {
                $trajet->setTrajet(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return sprintf('%s to %s', $this->depart, $this->destination);
    }

}
