<?php

namespace App\Entity;

use App\Repository\PlateformeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlateformeRepository::class)]
class Plateforme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, InformationJeux>
     */
    #[ORM\ManyToMany(targetEntity: InformationJeux::class, inversedBy: 'plateformes')]
    private Collection $information_jeux;

    #[ORM\Column]
    private ?bool $ps4 = null;

    #[ORM\Column]
    private ?bool $xbox = null;

    #[ORM\Column]
    private ?bool $pc = null;

    public function __construct()
    {
        $this->information_jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, InformationJeux>
     */
    public function getInformationJeux(): Collection
    {
        return $this->information_jeux;
    }

    public function addInformationJeux(InformationJeux $informationJeux): static
    {
        if (!$this->information_jeux->contains($informationJeux)) {
            $this->information_jeux->add($informationJeux);
        }

        return $this;
    }

    public function removeInformationJeux(InformationJeux $informationJeux): static
    {
        $this->information_jeux->removeElement($informationJeux);

        return $this;
    }

    public function isPs4(): ?bool
    {
        return $this->ps4;
    }

    public function setPs4(bool $ps4): static
    {
        $this->ps4 = $ps4;

        return $this;
    }

    public function isXbox(): ?bool
    {
        return $this->xbox;
    }

    public function setXbox(bool $xbox): static
    {
        $this->xbox = $xbox;

        return $this;
    }

    public function isPc(): ?bool
    {
        return $this->pc;
    }

    public function setPc(bool $pc): static
    {
        $this->pc = $pc;

        return $this;
    }
}
