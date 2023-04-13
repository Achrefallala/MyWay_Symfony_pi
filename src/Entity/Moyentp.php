<?php

namespace App\Entity;

use App\Repository\MoyentpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MoyentpRepository::class)]
#[UniqueEntity('matricule', message: 'Cette matricule est déjà utilisée. Veuillez en choisir une autre.')]
class Moyentp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
   
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(choices: ['BUS', 'TRAIN', 'METRO'], message: 'Le type doit être BUS, TRAIN ou METRO.')]
    private ?string $type = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive(message: 'Le nombre de places doit être un entier positif.')]
    private ?int $nbreplace = null;

    #[ORM\Column(type: 'float')]
    #[Assert\Positive(message: 'Le prix du ticket doit être un nombre positif.')]
    private ?float $prix_ticket = null;

    #[ORM\Column(length: 255)]
    private ?string $horaire = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'moyentp', targetEntity: Ligne::class)]
    private Collection $moyentp;

    public function __construct()
    {
        $this->moyentp = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNbreplace(): ?int
    {
        return $this->nbreplace;
    }

    public function setNbreplace(int $nbreplace): self
    {
        $this->nbreplace = $nbreplace;

        return $this;
    }

    public function getPrixTicket(): ?float
    {
        return $this->prix_ticket;
    }

    public function setPrixTicket(float $prix_ticket): self
    {
        $this->prix_ticket = $prix_ticket;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Ligne>
     */
    public function getMoyentp(): Collection
    {
        return $this->moyentp;
    }

    public function addMoyentp(Ligne $moyentp): self
    {
        if (!$this->moyentp->contains($moyentp)) {
            $this->moyentp->add($moyentp);
            $moyentp->setMoyentp($this);
        }

        return $this;
    }

    public function removeMoyentp(Ligne $moyentp): self
    {
        if ($this->moyentp->removeElement($moyentp)) {
            // set the owning side to null (unless already changed)
            if ($moyentp->getMoyentp() === $this) {
                $moyentp->setMoyentp(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom . ' (' . $this->matricule . ')';
    }
    
}
