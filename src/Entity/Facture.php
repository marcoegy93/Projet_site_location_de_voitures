<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Facture
 *
 * @ORM\Table(name="facture", uniqueConstraints={@ORM\UniqueConstraint(name="UC_Facture", columns={"ide", "idv", "date_d"})}, indexes={@ORM\Index(name="idv", columns={"idv"}), @ORM\Index(name="IDX_FE866410840E12C9", columns={"ide"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     * @ORM\Column(name="id_facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFacture;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="date_d", type="date", nullable=false)
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateD;

    /**
     * @var 
     * @ORM\Column(name="date_f", type="date", nullable=true)
     * @Assert\Date()
     * @Assert\Expression("this.getDateF()==null or this.getDateD() <= this.getDateF()", 
     * message="La date fin ne doit pas être antérieure à la date début")
     */
    private ?\DateTimeInterface $dateF=null;
    

    /**
     * @var float
     *
     * @ORM\Column(name="valeur", type="float", precision=10, scale=0, nullable=false)
     */
    private $valeur;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat_r", type="boolean", nullable=false)
     */
    private $etatR;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ide", referencedColumnName="id_utilisateur")
     * })
     */
    private $ide;

    /**
     * @var Vehicule
     *
     * @ORM\ManyToOne(targetEntity="Vehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idv", referencedColumnName="id_vehicule")
     * })
     */
    private $idv;

        /**
     * @var bool
     *
     * @ORM\Column(name="retourne", type="boolean", nullable=false)
     */
    private $retourne;
    /**
     * @var bool
     *
     * @ORM\Column(name="revision", type="boolean", nullable=false)
     */
    private $revision;

    public function getIdFacture(): ?int
    {
        return $this->idFacture;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->dateF;
    }

    public function setDateF(?\DateTimeInterface $dateF): self
    {
        $this->dateF = $dateF;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getEtatR(): ?bool
    {
        return $this->etatR;
    }

    public function setEtatR(bool $etatR): self
    {
        $this->etatR = $etatR;

        return $this;
    }

    public function getIde(): ?Utilisateur
    {
        return $this->ide;
    }

    public function setIde(?Utilisateur $ide): self
    {
        $this->ide = $ide;

        return $this;
    }

    public function getIdv(): ?Vehicule
    {
        return $this->idv;
    }

    public function setIdv(?Vehicule $idv): self
    {
        $this->idv = $idv;

        return $this;
    }


    public function getRevision(): ?bool
    {
        return $this->revision;
    }

    public function setRevision(bool $revision): self
    {
        $this->revision = $revision;

        return $this;
    }

    public function getRetourne(): ?bool
    {
        return $this->retourne;
    }

    public function setRetourne(bool $retourne): self
    {
        $this->retourne = $retourne;

        return $this;
    }

}
