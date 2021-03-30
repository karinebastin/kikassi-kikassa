<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpruntRepository::class)
 */
class Emprunt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_reservation;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remarque;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_retour_objet;

    /**
     * @ORM\Column(type="integer")
     */
    private $depot_rajoute;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $penalites;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_emprunt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Objet::class, inversedBy="emprunts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $objet;

    /**
     * @ORM\ManyToOne(targetEntity=Adherent::class, inversedBy="emprunts")
     */
    private $adherent;

    /**
     * @ORM\ManyToOne(targetEntity=SuperAdmin::class, inversedBy="emprunts")
     */
    private $super_admin;

    /**
     * @ORM\ManyToOne(targetEntity=StatutEmprunt::class, inversedBy="emprunts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statut_emprunt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDateReservation(?\DateTimeInterface $date_reservation): self
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getDateRetourObjet(): ?\DateTimeInterface
    {
        return $this->date_retour_objet;
    }

    public function setDateRetourObjet(?\DateTimeInterface $date_retour_objet): self
    {
        $this->date_retour_objet = $date_retour_objet;

        return $this;
    }

    public function getDepotRajoute(): ?int
    {
        return $this->depot_rajoute;
    }

    public function setDepotRajoute(int $depot_rajoute): self
    {
        $this->depot_rajoute = $depot_rajoute;

        return $this;
    }

    public function getPenalites(): ?int
    {
        return $this->penalites;
    }

    public function setPenalites(?int $penalites): self
    {
        $this->penalites = $penalites;

        return $this;
    }

    public function getPrixEmprunt(): ?int
    {
        return $this->prix_emprunt;
    }

    public function setPrixEmprunt(int $prix_emprunt): self
    {
        $this->prix_emprunt = $prix_emprunt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getObjet(): ?Objet
    {
        return $this->objet;
    }

    public function setObjet(?Objet $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function getSuperAdmin(): ?SuperAdmin
    {
        return $this->super_admin;
    }

    public function setSuperAdmin(?SuperAdmin $super_admin): self
    {
        $this->super_admin = $super_admin;

        return $this;
    }

    public function getStatutEmprunt(): ?StatutEmprunt
    {
        return $this->statut_emprunt;
    }

    public function setStatutEmprunt(?StatutEmprunt $statut_emprunt): self
    {
        $this->statut_emprunt = $statut_emprunt;

        return $this;
    }
}