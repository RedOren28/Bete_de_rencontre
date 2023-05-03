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
    private ?string $Nom = null;

    #[ORM\Column]
    private ?bool $Sexe = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Vermifugation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Vaccin = null;

    #[ORM\Column(nullable: true)]
    private ?int $Puce_Tatouage = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function isSexe(): ?bool
    {
        return $this->Sexe;
    }

    public function setSexe(bool $Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function isVermifugation(): ?bool
    {
        return $this->Vermifugation;
    }

    public function setVermifugation(?bool $Vermifugation): self
    {
        $this->Vermifugation = $Vermifugation;

        return $this;
    }

    public function isVaccin(): ?bool
    {
        return $this->Vaccin;
    }

    public function setVaccin(?bool $Vaccin): self
    {
        $this->Vaccin = $Vaccin;

        return $this;
    }

    public function getPuceTatouage(): ?int
    {
        return $this->Puce_Tatouage;
    }

    public function setPuceTatouage(?int $Puce_Tatouage): self
    {
        $this->Puce_Tatouage = $Puce_Tatouage;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
