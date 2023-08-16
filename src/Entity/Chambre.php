<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'chambre', targetEntity: Calendar::class)]
    private Collection $reservation;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    private ?string $color = null;

    #[ORM\OneToOne(inversedBy: 'chambre', cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Calendar>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Calendar $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setChambre($this);
        }

        return $this;
    }

    public function removeReservation(Calendar $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getChambre() === $this) {
                $reservation->setChambre(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }


}
