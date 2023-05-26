<?php

namespace App\Entity;

use App\Repository\RegimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegimeRepository::class)]
class Regime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'Regime', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\ManyToMany(targetEntity: Alimentation::class, inversedBy: 'regimes', cascade:["persist"])]
    private Collection $alimentations;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->alimentations = new ArrayCollection();
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

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setRegime($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getRegime() === $this) {
                $animal->setRegime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Alimentation>
     */
    public function getAlimentations(): Collection
    {
        return $this->alimentations;
    }

    public function addAlimentation(Alimentation $alimentation): self
    {
        if (!$this->alimentations->contains($alimentation)) {
            $this->alimentations->add($alimentation);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): self
    {
        $this->alimentations->removeElement($alimentation);

        return $this;
    }
}
