<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialistRepository")
 */
class Specialist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="specialist")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visit", mappedBy="specialist")
     */
    private $visit;

    public function __construct()
    {
        $this->client = new ArrayCollection();
        $this->visit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setSpecialist($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->client->contains($client)) {
            $this->client->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getSpecialist() === $this) {
                $client->setSpecialist(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection|Visit[]
     */
    public function getVisit(): Collection
    {
        return $this->visit;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visit->contains($visit)) {
            $this->visit[] = $visit;
            $visit->setSpecialist($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visit->contains($visit)) {
            $this->visit->removeElement($visit);
            // set the owning side to null (unless already changed)
            if ($visit->getSpecialist() === $this) {
                $visit->setSpecialist(null);
            }
        }

        return $this;
    }

    public function getAvgServiceTime()
    {
        $entityManager = $this->getEntityManager();


    }
}
