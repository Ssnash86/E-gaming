<?php

namespace App\Entity;

use App\Repository\InformationJeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationJeuxRepository::class)]
class InformationJeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $stocks = null;

    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $studio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $date_parution = null;

    /**
     * @var Collection<int, Joueur>
     */
    #[ORM\ManyToMany(targetEntity: Joueur::class, mappedBy: 'information_jeu', cascade: ['persist', 'remove'])]
    private Collection $player;

    #[ORM\OneToOne(mappedBy: 'information_jeux', cascade: ['persist', 'remove'])]
    private ?Jeux $jeux = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_jeux = null;

    /**
     * @var Collection<int, Plateforme>
     */
    #[ORM\ManyToMany(targetEntity: Plateforme::class, mappedBy: 'information_jeux', cascade: ['persist', 'remove'])]
    private Collection $plateformes;

    public function __construct()
    {
        $this->player = new ArrayCollection();
        $this->plateformes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStocks(): ?int
    {
        return $this->stocks;
    }

    public function setStocks(?int $stocks): static
    {
        $this->stocks = $stocks;

        return $this;
    }

    public function getStudio(): ?string
    {
        return $this->studio;
    }

    public function setStudio(string $studio): static
    {
        $this->studio = $studio;

        return $this;
    }

    public function getDateParution(): ?\DateTimeInterface
    {
        return $this->date_parution;
    }

    public function setDateParution(\DateTimeInterface $date_parution): static
    {
        $this->date_parution = $date_parution;

        return $this;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getPlayer(): Collection
    {
        return $this->player;
    }

    public function addPlayer(Joueur $informationJeux): static
    {
        if (!$this->player->contains($informationJeux)) {
            $this->player->add($informationJeux);
            $informationJeux->addInformationJeu($this);
        }

        return $this;
    }

    public function removePlayer(Joueur $informationJeux): static
    {
        if ($this->player->removeElement($informationJeux)) {
            $informationJeux->removeInformationJeu($this);
        }

        return $this;
    }

    public function getJeux(): ?Jeux
    {
        return $this->jeux;
    }

    public function setJeux(?Jeux $jeux): static
    {
        // unset the owning side of the relation if necessary
        if ($jeux === null && $this->jeux !== null) {
            $this->jeux->setInformationJeux(null);
        }

        // set the owning side of the relation if necessary
        if ($jeux !== null && $jeux->getInformationJeux() !== $this) {
            $jeux->setInformationJeux($this);
        }

        $this->jeux = $jeux;

        return $this;
    }

    public function getDescriptionJeux(): ?string
    {
        return $this->description_jeux;
    }

    public function setDescriptionJeux(string $description_jeux): static
    {
        $this->description_jeux = $description_jeux;

        return $this;
    }
    public function __toString()
    {
        return $this->getJeux();
    }

    /**
     * @return Collection<int, Plateforme>
     */
    public function getPlateformes(): Collection
    {
        return $this->plateformes;
    }

    public function addPlateforme(Plateforme $plateforme): static
    {
        if (!$this->plateformes->contains($plateforme)) {
            $this->plateformes->add($plateforme);
            $plateforme->addInformationJeux($this);
        }

        return $this;
    }

    public function removePlateforme(Plateforme $plateforme): static
    {
        if ($this->plateformes->removeElement($plateforme)) {
            $plateforme->removeInformationJeux($this);
        }

        return $this;
    }
}
