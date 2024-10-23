<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuxRepository::class)]
class Jeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(nullable: true )]
    private ?int $reduction = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $img = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'jeux' , cascade: ['persist', 'remove'])]
    private Collection $categories;

    #[ORM\Column(type: Types::TEXT , nullable: true)]
    private ?string $img_3d = null;

    /**
     * @var Collection<int, ImgJeux>
     */
    #[ORM\OneToMany(targetEntity: ImgJeux::class, mappedBy: 'jeux', cascade: ['persist', 'remove'])]
    private Collection $imgJeuxes;

    #[ORM\Column]
    private ?bool $prime = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $img_log = null;

    #[ORM\OneToOne(inversedBy: 'jeux', cascade: ['persist', 'remove'])]
    private ?InformationJeux $information_jeux = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'jeux', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $commentaires;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->imgJeuxes = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
       
       
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(?int $reduction): static
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addJeux($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeJeux($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }

    public function getImg3d(): ?string
    {
        return $this->img_3d;
    }

    public function setImg3d(string $img_3d): static
    {
        $this->img_3d = $img_3d;

        return $this;
    }

    /**
     * @return Collection<int, ImgJeux>
     */
    public function getImgJeuxes(): Collection
    {
        return $this->imgJeuxes;
    }

    public function addImgJeux(ImgJeux $imgJeux): static
    {
        if (!$this->imgJeuxes->contains($imgJeux)) {
            $this->imgJeuxes->add($imgJeux);
            $imgJeux->setJeux($this);
        }

        return $this;
    }

    public function removeImgJeux(ImgJeux $imgJeux): static
    {
        if ($this->imgJeuxes->removeElement($imgJeux)) {
            // set the owning side to null (unless already changed)
            if ($imgJeux->getJeux() === $this) {
                $imgJeux->setJeux(null);
            }
        }

        return $this;
    }

    public function isPrime(): ?bool
    {
        return $this->prime;
    }

    public function setPrime(bool $prime): static
    {
        $this->prime = $prime;

        return $this;
    }

    public function getImgLog(): ?string
    {
        return $this->img_log;
    }

    public function setImgLog(string $img_log): static
    {
        $this->img_log = $img_log;

        return $this;
    }

    public function getInformationJeux(): ?InformationJeux
    {
        return $this->information_jeux;
    }

    public function setInformationJeux(?InformationJeux $information_jeux): static
    {
        $this->information_jeux = $information_jeux;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setJeux($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getJeux() === $this) {
                $commentaire->setJeux(null);
            }
        }

        return $this;
    }
}
