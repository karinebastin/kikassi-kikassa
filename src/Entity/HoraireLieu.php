<?php

namespace App\Entity;

use App\Repository\HoraireLieuRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotBlank(message:"Veuillez sélectionner le jour")]

    private $jour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ouv_am;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ferme_am;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ouv_pm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ferme_pm;

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

    public function getOuvAm(): ?string
    {
        return $this->ouv_am;
    }

    public function setOuvAm(string $ouv_am): self
    {
        $this->ouv_am = $ouv_am;

        return $this;
    }

    public function getFermeAm(): ?string
    {
        return $this->ferme_am;
    }

    public function setFermeAm(string $ferme_am): self
    {
        $this->ferme_am = $ferme_am;

        return $this;
    }

    public function getOuvPm(): ?string
    {
        return $this->ouv_pm;
    }

    public function setOuvPm(string $ouv_pm): self
    {
        $this->ouv_pm = $ouv_pm;

        return $this;
    }

    public function getFermePm(): ?string
    {
        return $this->ferme_pm;
    }

    public function setFermePm(string $ferme_pm): self
    {
        $this->ferme_pm = $ferme_pm;

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