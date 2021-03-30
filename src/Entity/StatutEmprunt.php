<?php

namespace App\Entity;

use App\Repository\StatutEmpruntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatutEmpruntRepository::class)
 */
class StatutEmprunt
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
    private $nom_statut;

    /**
     * @ORM\OneToMany(targetEntity=Emprunt::class, mappedBy="statut_emprunt")
     */
    private $emprunts;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStatut(): ?string
    {
        return $this->nom_statut;
    }

    public function setNomStatut(string $nom_statut): self
    {
        $this->nom_statut = $nom_statut;

        return $this;
    }

    /**
     * @return Collection|Emprunt[]
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts[] = $emprunt;
            $emprunt->setStatutEmprunt($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getStatutEmprunt() === $this) {
                $emprunt->setStatutEmprunt(null);
            }
        }

        return $this;
    }
}
