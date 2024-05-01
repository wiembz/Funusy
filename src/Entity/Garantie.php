<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GarantieRepository;

#[ORM\Entity(repositoryClass: GarantieRepository::class)]

class Garantie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_garantie", type: "integer", nullable: false)]
    private ?int $idGarantie;

    #[ORM\Column(name: "id_credit", type: "integer", nullable: true)]
    private ?int $idCredit;

    #[ORM\Column(name: "nature_garantie", type: "string", length: 0, nullable: false)]
    private string $natureGarantie;

    #[ORM\Column(name: "Valeur_Garantie", type: "float", precision: 10, scale: 0, nullable: true)]
    private ?float $valeurGarantie;

    #[ORM\Column(name: "preuve", type: "string", length: 8000, nullable: true)]
    private ?string $preuve;

    public function getIdGarantie(): ?int
    {
        return $this->idGarantie;
    }

    public function getIdCredit(): ?int
    {
        return $this->idCredit;
    }

    public function setIdCredit(?int $idCredit): static
    {
        $this->idCredit = $idCredit;
        return $this;
    }

    public function getNatureGarantie(): ?string
    {
        return $this->natureGarantie;
    }

    public function setNatureGarantie(string $natureGarantie): static
    {
        $this->natureGarantie = $natureGarantie;
        return $this;
    }

    public function getValeurGarantie(): ?float
    {
        return $this->valeurGarantie;
    }

    public function setValeurGarantie(?float $valeurGarantie): static
    {
        $this->valeurGarantie = $valeurGarantie;
        return $this;
    }

    public function getPreuve(): ?string
    {
        return $this->preuve;
    }

    public function setPreuve(?string $preuve): static
    {
        $this->preuve = $preuve;
        return $this;
    }
}
