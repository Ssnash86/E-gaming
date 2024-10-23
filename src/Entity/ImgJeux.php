<?php

namespace App\Entity;

use App\Repository\ImgJeuxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImgJeuxRepository::class)]
class ImgJeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'imgJeuxes')]
    private ?jeux $jeux = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $img = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJeux(): ?jeux
    {
        return $this->jeux;
    }

    public function setJeux(?jeux $jeux): static
    {
        $this->jeux = $jeux;

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
    public function __toString()
    {
        return  $this->jeux;
    }
}
