<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule")
 * @ORM\Entity
 */
class Vehicule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_vehicule", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVehicule;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

        /**
     * @var int
     *
     * @ORM\Column(name="nb", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $nb;

    /**
     * @var array
     *
     * @ORM\Column(name="caract", type="json", nullable=false)
     */
    private $caract;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var array
     *
     * @ORM\Column(name="vehiculesDispo", type="json", length=255, nullable=false)
     */
    private $vehiculesDispo;

    /**
     * @var array
     *
     * @ORM\Column(name="vehiculesLoues", type="json", length=255, nullable=false)
     */
    private $vehiculesLoues;

    /**
     * @var array
     *
     * @ORM\Column(name="vehiculesEnRevision", type="json", length=255, nullable=false)
     */
    private $vehiculesEnRevision;

    /**
     * @var float|null
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;



    public function getIdVehicule(): ?int
    {
        return $this->idVehicule;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(int $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    public function getCaract(): ?array
    {
        return $this->caract;
    }

    public function setCaract(array $caract): self
    {
        $this->caract = $caract;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getVehiculesDispo(): ?array
    {
        return $this->vehiculesDispo;
    }

    public function setVehiculesDispo(array $vehiculesDispo): self
    {
        $this->vehiculesDispo = $vehiculesDispo;

        return $this;
    }

    public function getVehiculesLoues(): ?array
    {
        return $this->vehiculesLoues;
    }

    public function setVehiculesLoues(array $vehiculesLoues): self
    {
        $this->vehiculesLoues = $vehiculesLoues;

        return $this;
    }

    public function getVehiculesEnRevision(): ?array
    {
        return $this->vehiculesEnRevision;
    }

    public function setVehiculesEnRevision(array $vehiculesEnRevision): self
    {
        $this->vehiculesEnRevision = $vehiculesEnRevision;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }



}
