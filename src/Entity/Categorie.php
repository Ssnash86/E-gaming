<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, jeux>
     */
    #[ORM\ManyToMany(targetEntity: Jeux::class, inversedBy: 'categories')]
    private Collection $jeux;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, jeux>
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeux(jeux $jeux): static
    {
        if (!$this->jeux->contains($jeux)) {
            $this->jeux->add($jeux);
        }

        return $this;
    }

    public function removeJeux(Jeux $jeux): static
    {
        $this->jeux->removeElement($jeux);

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
