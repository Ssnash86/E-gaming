<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $solo = null;

    #[ORM\Column(nullable: true)]
    private ?bool $multi = null;

    /**
     * @var Collection<int, InformationJeux>
     */
    #[ORM\ManyToMany(targetEntity: InformationJeux::class, inversedBy: 'information_jeux')]
    private Collection $information_jeu;

    #[ORM\Column]
    private ?bool $duo = null;

    public function __construct()
    {
        $this->information_jeu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSolo(): ?bool
    {
        return $this->solo;
    }

    public function setSolo(?bool $solo): static
    {
        $this->solo = $solo;

        return $this;
    }

    public function isMulti(): ?bool
    {
        return $this->multi;
    }

    public function setMulti(?bool $multi): static
    {
        $this->multi = $multi;

        return $this;
    }

    /**
     * @return Collection<int, InformationJeux>
     */
    public function getInformationJeu(): Collection
    {
        return $this->information_jeu;
    }

    public function addInformationJeu(InformationJeux $informationJeu): static
    {
        if (!$this->information_jeu->contains($informationJeu)) {
            $this->information_jeu->add($informationJeu);
        }

        return $this;
    }

    public function removeInformationJeu(InformationJeux $informationJeu): static
    {
        $this->information_jeu->removeElement($informationJeu);

        return $this;
    }

    public function isDuo(): ?bool
    {
        return $this->duo;
    }

    public function setDuo(bool $duo): static
    {
        $this->duo = $duo;

        return $this;
    }
    // public function __toString()
    // {
    //     return "solo: ". $this->solo?"Oui":"Non" ."duo: $this->duo multi: $this->multi";

    // }
}
