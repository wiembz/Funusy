<?php

namespace App\Entity;

use App\Repository\InvestissementRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvestissementRepository::class)]
class Investissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idInvestissement = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le montant ne doit pas être vide')]
    #[Assert\Type('float', message: 'Le montant doit être un nombre')]
    #[Assert\Positive(message: 'Le montant doit être un nombre positif')]
    private ?float $montant = null;

    #[ORM\Column(name: "date_inv", type: "date", nullable: false)]
    #[Assert\NotNull(message: 'La date d\'investissement ne doit pas être vide')]
    #[Assert\Greater(value: 'today', message: 'La date d\'investissement doit être sup à la date du jour')]
    private ?DateTimeInterface $dateInv;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Periode ne doit pas être vide')]
    private int $periode;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")]
    
    private ?User $user;

    #[ORM\ManyToOne(targetEntity: Projet::class)]
    #[ORM\JoinColumn(name: "id_projet", referencedColumnName: "id_projet")]
    private ?Projet $projet;

    public function getIdInvestissement(): ?int
    {
        return $this->idInvestissement;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getDateInv(): ?\DateTimeInterface
    {
        return $this->dateInv;
    }

    public function setDateInv(\DateTimeInterface $dateInv): self
    {
        $this->dateInv = $dateInv;
        return $this;
    }

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(int $periode): self
    {
        $this->periode = $periode;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;
        return $this;
    }

    public function __construct()
    {
        $this->dateInv = new DateTime();
    }
}
