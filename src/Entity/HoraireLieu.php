<?php

namespace App\Entity;

use App\Repository\HoraireLieuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HoraireLieuRepository::class)
 */
class HoraireLieu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $ouv_am;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $ferme_am;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $ouv_pm;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $ferme_pm;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fermeture;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="horaire_lieu")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getOuvAm(): ?\DateTimeInterface
    {
        return $this->ouv_am;
    }

    public function setOuvAm(?\DateTimeInterface $ouv_am): self
    {
        $this->ouv_am = $ouv_am;

        return $this;
    }

    public function getFermeAm(): ?\DateTimeInterface
    {
        return $this->ferme_am;
    }

    public function setFermeAm(?\DateTimeInterface $ferme_am): self
    {
        $this->ferme_am = $ferme_am;

        return $this;
    }

    public function getOuvPm(): ?\DateTimeInterface
    {
        return $this->ouv_pm;
    }

    public function setOuvPm(?\DateTimeInterface $ouv_pm): self
    {
        $this->ouv_pm = $ouv_pm;

        return $this;
    }

    public function getFermePm(): ?\DateTimeInterface
    {
        return $this->ferme_pm;
    }

    public function setFermePm(?\DateTimeInterface $ferme_pm): self
    {
        $this->ferme_pm = $ferme_pm;

        return $this;
    }

    public function getFermeture(): ?bool
    {
        return $this->fermeture;
    }

    public function setFermeture(bool $fermeture): self
    {
        $this->fermeture = $fermeture;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

}