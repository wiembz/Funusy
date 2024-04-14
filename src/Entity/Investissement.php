<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\InvestissementRepository;
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

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")] // Assuming the column name in User entity is id_user
    private ?User $user;

    #[ORM\ManyToOne(targetEntity: Projet::class)]
    #[ORM\JoinColumn(name: "id_projet", referencedColumnName: "id_projet")] // Assuming the column name in Projet entity is id_projet
    private ?Projet $projet;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;
        return $this;
    }
}
