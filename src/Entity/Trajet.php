<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $depart = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $etat = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $directions = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[Assert\Type(type: 'float', message: "Veuillez saisir un nombre")]
    #[ORM\Column]
    private ?float $latitude = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[Assert\Type(type: 'float', message:"Veuillez saisir un nombre")]
    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\OneToMany(mappedBy: 'trajet', targetEntity: Etablissement::class)]
    private Collection $etablissements;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    //#[Assert\Type(type: 'numeric', message: "Veuillez saisir un nombre")]
    #[Assert\Positive(message: "La distance doit étre positive")]
    #[ORM\Column]
    private ?float $distance = null;

    #[ORM\Column]
    private ?int $views = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreation = null;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(?string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): self
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->setTrajet($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): self
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getTrajet() === $this) {
                $etablissement->setTrajet(null);
            }
        }

        return $this;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(?float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    
}
