<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjetRepository::class)
 */
class Objet
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
    private $denomination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $valeur_achat;

    /**
     * @ORM\Column(type="integer")
     */
    private $coef_usure;

    /**
     * @ORM\Column(type="integer")
     */
    private $pourcent_calcul;

    /**
     * @ORM\Column(type="boolean")
     */
    private $vitrine;

    /**
     * @ORM\ManyToOne(targetEntity=Adherent::class, inversedBy="objets")
     */
    private $adherent;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;


    /**
     * @ORM\ManyToOne(targetEntity=StatutObjet::class, inversedBy="objets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statut_objet;

    /**
     * @ORM\OneToMany(targetEntity=Emprunt::class, mappedBy="objet", orphanRemoval=true)
     */
    private $emprunts;

    /**
     * @ORM\ManyToMany(targetEntity=Catalogue::class, inversedBy="objets")
     */
    private $catalogue;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="objets")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorie::class, inversedBy="objets")
     */
    private $sous_categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="objets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->catalogue = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getValeurAchat(): ?int
    {
        return $this->valeur_achat;
    }

    public function setValeurAchat(int $valeur_achat): self
    {
        $this->valeur_achat = $valeur_achat;

        return $this;
    }

    public function getCoefUsure(): ?int
    {
        return $this->coef_usure;
    }

    public function setCoefUsure(int $coef_usure): self
    {
        $this->coef_usure = $coef_usure;

        return $this;
    }

    public function getPourcentCalcul(): ?int
    {
        return $this->pourcent_calcul;
    }

    public function setPourcentCalcul(int $pourcent_calcul): self
    {
        $this->pourcent_calcul = $pourcent_calcul;

        return $this;
    }

    public function getVitrine(): ?bool
    {
        return $this->vitrine;
    }

    public function setVitrine(bool $vitrine): self
    {
        $this->vitrine = $vitrine;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getStatutObjet(): ?StatutObjet
    {
        return $this->statut_objet;
    }

    public function setStatutObjet(?StatutObjet $statut_objet): self
    {
        $this->statut_objet = $statut_objet;

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
            $emprunt->setObjet($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getObjet() === $this) {
                $emprunt->setObjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Catalogue[]
     */
    public function getCatalogue(): Collection
    {
        return $this->catalogue;
    }

    public function addCatalogue(Catalogue $catalogue): self
    {
        if (!$this->catalogue->contains($catalogue)) {
            $this->catalogue[] = $catalogue;
        }

        return $this;
    }

    public function removeCatalogue(Catalogue $catalogue): self
    {
        $this->catalogue->removeElement($catalogue);

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sous_categorie;
    }

    public function setSousCategorie(?SousCategorie $sous_categorie): self
    {
        $this->sous_categorie = $sous_categorie;

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