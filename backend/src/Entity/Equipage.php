<?php

namespace App\Entity;

use App\Repository\EquipageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipageRepository::class)]
class Equipage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Pirate>
     */
    #[ORM\OneToMany(targetEntity: Pirate::class, mappedBy: 'association', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $pirates;

    public function __construct()
    {
        $this->pirates = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Pirate>
     */
    public function getPirate(): Collection
    {
        return $this->pirates;
    }

    public function addPirate(Pirate $pirate): static
    {
        if (!$this->pirates->contains($pirate)) {
            $this->pirates->add($pirate);
            $pirate->setAssociation($this);
        }

        return $this;
    }

    public function removePirate(Pirate $pirate): static
    {
        if ($this->pirates->removeElement($pirate)) {
            if ($pirate->getAssociation() === $this) {
                $pirate->setAssociation(null);
            }
        }

        return $this;
    }
}
