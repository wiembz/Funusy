<?php

namespace App\Entity;

use App\Repository\GarantieRepository;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as assert;


#[ORM\Entity(repositoryClass: GarantieRepository::class)]
class Garantie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_garantie", type: "integer", nullable: false)]
    private ?int $idGarantie;

    #[ORM\Column(name: "id_credit", type: "integer", nullable: true)]
    #[assert\NotBlank(message: 'The credit identifier is mandatory')]
    private ?int $idCredit;

    #[ORM\Column(name: "nature_garantie", type: "string", length: 0, nullable: false)]
    #[assert\NotBlank(message: 'The nature of the guarantee is mandatory')]
    #[assert\Choice(choices: ['Maison', 'Voiture', 'Terrain', 'Local Commercial'], message: 'La nature de la garantie doit être parmi les valeurs proposées')]
    private string $natureGarantie;

    #[ORM\Column(name: "Valeur_Garantie", type: "float", precision: 10, scale: 0, nullable: true)]
    #[assert\NotBlank(message: 'The value of the guarantee is mandatory')]
    #[assert\Positive(message: 'The value of the guarantee must be positive')]
    #[assert\GreaterThanOrEqual(value: 10000, message: 'The value of the guarantee must be greater than or equal to 10000')]
    #[AppAssert\MontantGarantieValide(options: ["montantCredit" => 12345])]
    #
    private ?float $valeurGarantie;

    #[ORM\Column(name: "preuve", type: "string", length: 8000, nullable: true)]
    #[assert\File(maxSize: '1024k', mimeTypes: ['application/pdf'])]
    #[assert\NotBlank(message: 'Proof is mandatory')]
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

    public function __toString()
    {
        return sprintf('%s (%s)', $this->natureGarantie, $this->valeurGarantie);
    }


}
