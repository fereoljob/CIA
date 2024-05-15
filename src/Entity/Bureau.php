<?php

namespace App\Entity;

use App\Repository\BureauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BureauRepository::class)]
class Bureau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $num_bureau = null;

    #[ORM\Column]
    private ?int $capacite_max = null;

    #[ORM\Column]
    private ?int $num_etage = null;

    /**
     * @var Collection<int, Personnel>
     */
    #[ORM\OneToMany(targetEntity: Personnel::class, mappedBy: 'bureau')]
    private Collection $personnels;

    public function __construct()
    {
        $this->personnels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumBureau(): ?string
    {
        return $this->num_bureau;
    }

    public function setNumBureau(string $num_bureau): static
    {
        $this->num_bureau = $num_bureau;

        return $this;
    }

    public function getCapaciteMax(): ?int
    {
        return $this->capacite_max;
    }

    public function setCapaciteMax(int $capacite_max): static
    {
        $this->capacite_max = $capacite_max;

        return $this;
    }

    public function getNumEtage(): ?int
    {
        return $this->num_etage;
    }

    public function setNumEtage(int $num_etage): static
    {
        $this->num_etage = $num_etage;

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnels(): Collection
    {
        return $this->personnels;
    }

    public function addPersonnel(Personnel $personnel): static
    {
        if (!$this->personnels->contains($personnel)) {
            $this->personnels->add($personnel);
            $personnel->setBureau($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): static
    {
        if ($this->personnels->removeElement($personnel)) {
            // set the owning side to null (unless already changed)
            if ($personnel->getBureau() === $this) {
                $personnel->setBureau(null);
            }
        }

        return $this;
    }
}
