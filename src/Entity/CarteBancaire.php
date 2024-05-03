<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StudentRepository;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class CarteBancaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "num_carte", type: "string", length: 16, nullable: false)]
    private string $numCarte;

    #[ORM\Column(name: "date_exp", type: "date", nullable: false)]
    private \DateTimeInterface $dateExp;

    #[ORM\Column(name: "code", type: "integer", nullable: false)]
    private int $code;

    #[ORM\Column(name: "CVV2", type: "integer", nullable: false)]
    private int $cvv2;

    #[ORM\ManyToOne(targetEntity: "Compte")]
    #[ORM\JoinColumn(name: "rib_id", referencedColumnName: "rib", onDelete: "CASCADE", unique: true)]
    private ?Compte $rib;

    public function getNumCarte(): ?string
    {
        return $this->numCarte;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->dateExp;
    }

    public function setDateExp(\DateTimeInterface $dateExp): static
    {
        $this->dateExp = $dateExp;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCvv2(): ?int
    {
        return $this->cvv2;
    }

    public function setCvv2(int $cvv2): static
    {
        $this->cvv2 = $cvv2;

        return $this;
    }

    public function getRib(): ?Compte
    {
        return $this->rib;
    }

    public function setRib(?Compte $rib): static
    {
        $this->rib = $rib;

        return $this;
    }
}
