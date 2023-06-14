<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 255)]
    private ?string $from_airport = null;

    #[ORM\Column(length: 255)]
    private ?string $to_airport = null;

    #[ORM\ManyToMany(targetEntity: Passenger::class, mappedBy: 'flight')]
    private Collection $passengers;

    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Steward::class)]
    private Collection $stewards;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Captain $captain = null;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
        $this->stewards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getFromAirport(): ?string
    {
        return $this->from_airport;
    }

    public function setFromAirport(string $from_airport): static
    {
        $this->from_airport = $from_airport;

        return $this;
    }

    public function getToAirport(): ?string
    {
        return $this->to_airport;
    }

    public function setToAirport(string $to_airport): static
    {
        $this->to_airport = $to_airport;

        return $this;
    }

    /**
     * @return Collection<int, Passenger>
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(Passenger $passenger): static
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers->add($passenger);
            $passenger->addFlight($this);
        }

        return $this;
    }

    public function removePassenger(Passenger $passenger): static
    {
        if ($this->passengers->removeElement($passenger)) {
            $passenger->removeFlight($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Steward>
     */
    public function getStewards(): Collection
    {
        return $this->stewards;
    }

    public function addSteward(Steward $steward): static
    {
        if (!$this->stewards->contains($steward)) {
            $this->stewards->add($steward);
            $steward->setFlight($this);
        }

        return $this;
    }

    public function removeSteward(Steward $steward): static
    {
        if ($this->stewards->removeElement($steward)) {
            // set the owning side to null (unless already changed)
            if ($steward->getFlight() === $this) {
                $steward->setFlight(null);
            }
        }

        return $this;
    }

    public function getCaptain(): ?Captain
    {
        return $this->captain;
    }

    public function setCaptain(?Captain $captain): static
    {
        $this->captain = $captain;

        return $this;
    }
}
