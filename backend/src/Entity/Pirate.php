<?php

namespace App\Entity;

use App\Repository\PirateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PirateRepository::class)]
class Pirate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $Prime = null;


    #[ORM\ManyToOne(inversedBy: 'membre')]
    private ?Equipage $association = null;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

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

    public function getPrime(): ?string
    {
        return $this->Prime;
    }

    public function setPrime(string $Prime): static
    {
        $this->Prime = $Prime;

        return $this;
    }

    public function getAssociation(): ?Equipage
    {
        return $this->association;
    }

    public function setAssociation(?Equipage $association): static
    {
        $this->association = $association;

        return $this;
    }
}
