<?php

namespace App\Entity;

use App\Repository\CalendarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendarRepository::class)]
class Calendar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTime $start = null;

    #[ORM\Column]
    private ?\DateTime $endReversed = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?Chambre $chambre = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $guests = null;

    #[ORM\Column(nullable: true)]
    private ?int $children = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEndReversed(): ?\DateTime
    {
        return $this->endReversed;
    }

    public function setEndReversed(\DateTime $endReversed): static
    {
        $this->endReversed = $endReversed;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): static
    {
        $this->chambre = $chambre;

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

    public function getGuests(): ?int
    {
        return $this->guests;
    }

    public function setGuests(?int $guests): static
    {
        $this->guests = $guests;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(?int $children): static
    {
        $this->children = $children;

        return $this;
    }


}
