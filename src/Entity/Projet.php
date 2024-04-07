<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjetRepository;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_projet", type: "integer", nullable: false)]
    private ?int $idProjet;

    #[ORM\Column(name: "nom_projet", type: "string", length: 255, nullable: false)]
    private string $nomProjet;

    #[ORM\Column(name: "montant_req", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $montantReq;

    #[ORM\Column(name: "longitude", type: "string", length: 255, nullable: false)]
    private string $longitude;

    #[ORM\Column(name: "latitude", type: "string", length: 255, nullable: false)]
    private string $latitude;

    #[ORM\Column(name: "type_projet", type: "string", length: 0, nullable: false)]
    private string $typeProjet;

    #[ORM\Column(name: "description", type: "string", length: 250, nullable: false)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")] // Assuming the column name in User entity is id_user
    private ?User $user;

    public function getIdProjet(): ?int
    {
        return $this->idProjet;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): static
    {
        $this->nomProjet = $nomProjet;
        return $this;
    }

    public function getMontantReq(): ?float
    {
        return $this->montantReq;
    }

    public function setMontantReq(float $montantReq): static
    {
        $this->montantReq = $montantReq;
        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getTypeProjet(): ?string
    {
        return $this->typeProjet;
    }

    public function setTypeProjet(string $typeProjet): static
    {
        $this->typeProjet = $typeProjet;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
}
