<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompteRepository;

#[ORM\Entity(repositoryClass: CompteRepository::class)]
class Compte
{
    // Define primary key with the 'rib' attribute
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "rib", type: "string", length: 20, nullable: false)]
    private string $rib;

    // Define 'solde' attribute representing the balance of the account
    #[ORM\Column(name: "solde", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $solde;

    // Define 'date_ouverture' attribute representing the opening date of the account
    #[ORM\Column(name: "date_ouverture", type: "date", nullable: false)]
    private \DateTimeInterface $dateOuverture;

    // Define 'type_compte' attribute representing the type of the account
    #[ORM\Column(name: "type_compte", type: "string", length: 255, nullable: false)]
    private string $typeCompte;

    #[ORM\Column(name: "id_user", type: "integer", nullable: true)]
    private ?int $id_user;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")]
    private ?User $user;



    
    public function __toString(): string

    {

        return $this->rib; // Assuming that there's a string property in Compte entity which holds account number.

    }
// Getters and setters for each attribute
    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): static
    {
        $this->solde = $solde;
        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(\DateTimeInterface $dateOuverture): static
    {
        $this->dateOuverture = $dateOuverture;
        return $this;
    }

    public function getTypeCompte(): ?string
    {
        return $this->typeCompte;
    }

    public function setTypeCompte(string $typeCompte): static
    {
        $this->typeCompte = $typeCompte;
        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): static
    {
        $this->idUser = $idUser;
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
