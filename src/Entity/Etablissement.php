<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue] 
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'etablissements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajet = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[Assert\Email(message:"Veuillez saisir un email")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $horaires = null;

    
    #[ORM\Column(nullable: true)]
    private ?int $views = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreation = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[Assert\Type(type: 'numeric', message:"Veuillez saisir un nombre")]
    #[Assert\Positive(message: "Veuillez saisir un numéro de téléphone valide")]
    #[Assert\Length(exactly: 8 , exactMessage: "le numéro de téléphone doit comporter 8 digits")]
    #[ORM\Column(nullable: true)]
    private ?int $telephone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    

    public function getHoraires(): ?string
    {
        return $this->horaires;
    }

    public function setHoraires(?string $horaires): self
    {
        $this->horaires = $horaires;

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

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
