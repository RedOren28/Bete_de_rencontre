<?php

namespace App\Entity;

use App\Entity\Annonce;
use App\Entity\Alimentation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Naissance = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Poil $poil = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Regime $Regime = null;

    #[ORM\ManyToMany(targetEntity: Alimentation::class, inversedBy: 'animals')]
    private Collection $alimentation;

    public function __construct()
    {
        $this->alimentation = new ArrayCollection();
    }

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->Date_Naissance;
    }

    public function setDateNaissance(\DateTimeInterface $Date_Naissance): self
    {
        $this->Date_Naissance = $Date_Naissance;

        return $this;
    }

    public function getPoil(): ?Poil
    {
        return $this->poil;
    }

    public function setPoil(?Poil $poil): self
    {
        $this->poil = $poil;

        return $this;
    }

    public function getRegime(): ?Regime
    {
        return $this->Regime;
    }

    public function setRegime(?Regime $Regime): self
    {
        $this->Regime = $Regime;

        return $this;
    }

    /**
     * @return Collection<int, Alimentation>
     */
    public function getalimentation(): Collection
    {
        return $this->alimentation;
    }

    public function addAlimentation(Alimentation $alimentation): self
    {
        if (!$this->alimentation->contains($alimentation)) {
            $this->alimentation->add($alimentation);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): self
    {
        $this->alimentation->removeElement($alimentation);

        return $this;
    }
}
