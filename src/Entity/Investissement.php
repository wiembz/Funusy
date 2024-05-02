<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
use App\Repository\UserRepository;
=======
use App\Repository\InvestissementRepository;
>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: InvestissementRepository::class)]

class Investissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_investissement", type: "integer", nullable: false)]
    private ?int $idInvestissement;

    #[ORM\Column(name: "montant", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $montant;

    #[ORM\Column(name: "date_inv", type: "date", nullable: false)]
    private \DateTimeInterface $dateInv;

    #[ORM\Column(name: "periode", type: "integer", nullable: false)]
    private int $periode;

    #[ORM\Column(name: "id_user", type: "integer", nullable: false)]
    private int $idUser;

    #[ORM\Column(name: "id_projet", type: "integer", nullable: false)]
    private int $idProjet;

    public function getIdInvestissement(): ?int
    {
        return $this->idInvestissement;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getDateInv(): ?\DateTimeInterface
    {
        return $this->dateInv;
    }

    public function setDateInv(\DateTimeInterface $dateInv): static
    {
        $this->dateInv = $dateInv;
        return $this;
    }

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(int $periode): static
    {
        $this->periode = $periode;
        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getIdProjet(): ?int
    {
        return $this->idProjet;
    }

    public function setIdProjet(int $idProjet): static
    {
        $this->idProjet = $idProjet;
        return $this;
    }
}
