<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SignaleRepository;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity(repositoryClass: SignaleRepository::class)]
class Signale
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_signal", type: "integer", nullable: false)]
    private ?int $idSignal;

    #[ORM\Column(name: "date_signal", type: "date", nullable: false)]
    private \DateTime $dateSignal;

    #[ORM\Column(name: "description", type: "string", length: 255, nullable: false)]
    private string $description;



    #[ORM\ManyToOne(targetEntity: Commentaire::class)]
    #[ORM\JoinColumn(name: "id_commentaire", referencedColumnName: "id_commentaire")]
    private ?Commentaire $idCommentaire;

    public function getIdSignal(): ?int
    {
        return $this->idSignal;
    }

    public function getDateSignal(): ?\DateTimeInterface
    {
        return $this->dateSignal;
    }

    public function setDateSignal(\DateTimeInterface $dateSignal): static
    {
        $this->dateSignal = $dateSignal;
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



    public function setEtatSignal(bool $etatSignal): static
    {
        $this->etatSignal = $etatSignal;
        return $this;
    }

    public function getIdCommentaire(): ?Commentaire
    {
        return $this->idCommentaire;
    }

    public function setIdCommentaire(?Commentaire $idCommentaire): static
    {
        $this->idCommentaire = $idCommentaire;
        return $this;
    }
}
