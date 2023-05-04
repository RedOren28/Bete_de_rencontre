<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $sexe = null;

    #[ORM\Column(nullable: true)]
    private ?bool $vermifugation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $vaccin = null;

    #[ORM\Column(nullable: true)]
    private ?int $puce_tatouage = null;

    #[ORM\OneToOne(inversedBy: 'animal', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annonce $Annonce = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Couleur $Couleur = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isSexe(): ?bool
    {
        return $this->sexe;
    }

    public function setSexe(bool $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function isVermifugation(): ?bool
    {
        return $this->vermifugation;
    }

    public function setVermifugation(?bool $vermifugation): self
    {
        $this->vermifugation = $vermifugation;

        return $this;
    }

    public function isVaccin(): ?bool
    {
        return $this->vaccin;
    }

    public function setVaccin(?bool $vaccin): self
    {
        $this->vaccin = $vaccin;

        return $this;
    }

    public function getPuceTatouage(): ?int
    {
        return $this->puce_tatouage;
    }

    public function setPuceTatouage(?int $puce_tatouage): self
    {
        $this->puce_tatouage = $puce_tatouage;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->Annonce;
    }

    public function setAnnonce(Annonce $Annonce): self
    {
        $this->Annonce = $Annonce;

        return $this;
    }

    public function getCouleur(): ?Couleur
    {
        return $this->Couleur;
    }

    public function setCouleur(?Couleur $Couleur): self
    {
        $this->Couleur = $Couleur;

        return $this;
    }
}
