<?php

namespace App\Entity;

use App\Repository\OrderJeuxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderJeuxRepository::class)]
class OrderJeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jeux $jeux = null;

    #[ORM\Column]
    private ?float $prix_unit = null;

    #[ORM\ManyToOne(inversedBy: 'order_jeux', cascade:["remove"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orders = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getJeux(): ?Jeux
    {
        return $this->jeux;
    }

    public function setJeux(?Jeux $jeux): static
    {
        $this->jeux = $jeux;

        return $this;
    }

    public function getPrixUnit(): ?float
    {
        return $this->prix_unit;
    }

    public function setPrixUnit(float $prix_unit): static
    {
        $this->prix_unit = $prix_unit;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }
}
