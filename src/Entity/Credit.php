<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CreditRepository;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_credit", type: "integer", nullable: false)]
    private ?int $idCredit;

    #[ORM\Column(name: "montant_credit", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $montantCredit;

    #[ORM\Column(name: "duree_credit", type: "integer", nullable: false)]
    private int $dureeCredit;

    #[ORM\Column(name: "date_credit", type: "date", nullable: false)]
    private \DateTimeInterface $dateCredit;

    #[ORM\Column(name: "taux_credit", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $tauxCredit;

    #[ORM\Column(name: "status", type: "string", length: 255, nullable: true, options: ["default" => "Non traité"])]
    private ?string $status = 'Non traité';

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")]
    private ?User $user;

    public function getIdCredit(): ?int
    {
        return $this->idCredit;
    }

    public function getMontantCredit(): ?float
    {
        return $this->montantCredit;
    }

    public function setMontantCredit(float $montantCredit): static
    {
        $this->montantCredit = $montantCredit;
        return $this;
    }

    public function getDureeCredit(): ?int
    {
        return $this->dureeCredit;
    }

    public function setDureeCredit(int $dureeCredit): static
    {
        $this->dureeCredit = $dureeCredit;
        return $this;
    }

    public function getDateCredit(): ?\DateTimeInterface
    {
        return $this->dateCredit;
    }

    public function setDateCredit(\DateTimeInterface $dateCredit): static
    {
        $this->dateCredit = $dateCredit;
        return $this;
    }

    public function getTauxCredit(): ?float
    {
        return $this->tauxCredit;
    }

    public function setTauxCredit(float $tauxCredit): static
    {
        $this->tauxCredit = $tauxCredit;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;
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
    public function __toString()
{
    return sprintf(
        'Credit #%d - Montant: %s, Durée: %d, Date: %s, Taux: %s, Statut: %s, Utilisateur: %s',
        $this->idCredit,
        $this->montantCredit,
        $this->dureeCredit,
        $this->dateCredit->format('d-m-Y'),
        $this->tauxCredit,
        $this->status,
        $this->user ? $this->user->getNomUser() : 'Aucun utilisateur'
    );
}

    
}
