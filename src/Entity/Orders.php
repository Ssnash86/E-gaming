<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_commande = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @var Collection<int, OrderJeux>
     */
    #[ORM\OneToMany(targetEntity: OrderJeux::class, mappedBy: 'orders', cascade: ["persist", "remove"])]
    private Collection $order_jeux;

    #[ORM\Column]
    private ?bool $payer = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $User = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $line1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $line2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postal_code = null;

    public function __construct()
    {
        $this->order_jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numero_commande;
    }

    public function setNumeroCommande(string $numero_commande): static
    {
        $this->numero_commande = $numero_commande;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, OrderJeux>
     */
    public function getOrderJeux(): Collection
    {
        return $this->order_jeux;
    }

    public function addOrderJeux(OrderJeux $orderJeux): static
    {
        if (!$this->order_jeux->contains($orderJeux)) {
            $this->order_jeux->add($orderJeux);
            $orderJeux->setOrders($this);
        }

        return $this;
    }

    public function removeOrderJeux(OrderJeux $orderJeux): static
    {
        if ($this->order_jeux->removeElement($orderJeux)) {
            // set the owning side to null (unless already changed)
            if ($orderJeux->getOrders() === $this) {
                $orderJeux->setOrders(null);
            }
        }

        return $this;
    }

    public function isPayer(): ?bool
    {
        return $this->payer;
    }

    public function setPayer(bool $payer): static
    {
        $this->payer = $payer;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(?string $line1): static
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): static
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }
}
