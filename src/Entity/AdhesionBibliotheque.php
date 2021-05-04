<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdhesionBibliothequeRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdhesionBibliothequeRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class AdhesionBibliotheque implements UserInterface
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
    private $mot_de_passe;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\NotBlank(message:"Veuillez entrer un montant pour le dépôt permanent versé")]
    private $depot_permanent;

    /**
     * @ORM\Column(type="date", nullable=true)
     */

    #[Assert\Type("\DateTimeInterface", message:"Veuillez entrer une date de fin de validité de Responsabilité Civile valide")]
    private $fin_rc;

    /**
     * @ORM\Column(type="boolean")
     */

    #[Assert\NotNull(message:"Veuillez indiquer si un justificatif d\identité a été fourni")]

    private $justif_identite;

    /**
     * @ORM\Column(type="boolean")
     */

    #[Assert\NotNull(message:"Veuillez indiquer si un justificatif de domicile a été fourni")]
    private $justif_domicile;

    /**
     * @ORM\Column(type="date")
     */
    private $date_inscription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $satut_inscription;

    /**
     * @ORM\OneToOne(targetEntity=Adherent::class, inversedBy="adhesionBibliotheque", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @ORM\Column(type="string", length=255)
     */

    #[Assert\NotNull(message:"Veuillez choisir une catégorie de fourmi")]
    private $categorie_fourmi;

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function updateDate()
    {
        if (empty($this->date_inscription)) {
            $this->date_inscription = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    public function getDepotPermanent(): ?int
    {
        return $this->depot_permanent;
    }

    public function setDepotPermanent(int $depot_permanent): self
    {
        $this->depot_permanent = $depot_permanent;

        return $this;
    }

    public function getFinRc(): ?\DateTimeInterface
    {
        return $this->fin_rc;
    }

    public function setFinRc(?\DateTimeInterface $fin_rc): self
    {
        $this->fin_rc = $fin_rc;

        return $this;
    }

    public function getJustifIdentite(): ?bool
    {
        return $this->justif_identite;
    }

    public function setJustifIdentite(bool $justif_identite): self
    {
        $this->justif_identite = $justif_identite;

        return $this;
    }

    public function getJustifDomicile(): ?bool
    {
        return $this->justif_domicile;
    }

    public function setJustifDomicile(bool $justif_domicile): self
    {
        $this->justif_domicile = $justif_domicile;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(
        \DateTimeInterface $date_inscription
    ): self {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function getSatutInscription(): ?string
    {
        return $this->satut_inscription;
    }

    public function setSatutInscription(string $satut_inscription): self
    {
        $this->satut_inscription = $satut_inscription;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(Adherent $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getPassword()
    {
        return $this->mot_de_passe;
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getCategorieFourmi(): ?string
    {
        return $this->categorie_fourmi;
    }

    public function setCategorieFourmi(string $categorie_fourmi): self
    {
        $this->categorie_fourmi = $categorie_fourmi;

        return $this;
    }
}