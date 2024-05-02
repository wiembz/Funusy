<?php

namespace App\Entity;

<<<<<<< HEAD
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
=======
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['emailUser'], message: 'There is already an account with this emailUser')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_user", type: "integer", nullable: false)]
    private ?int $id_user;
    
<<<<<<< HEAD

    #[ORM\Column(name: "nom_user", type: "string", length: 255, nullable: false)]
    private string $nomUser;

    #[ORM\Column(name: "prenom_user", type: "string", length: 255, nullable: false)]
    private string $prenomUser;

    #[ORM\Column(name: "email_user", type: "string", length: 255, nullable: false)]
    private string $emailUser;

    #[ORM\Column(name: "mdp", type: "string", length: 255, nullable: false)]
    private string $mdp;

    #[ORM\Column(name: "salaire", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $salaire;

    #[ORM\Column(name: "date_naissance", type: "date", nullable: false)]
    private \DateTime $dateNaissance;

    #[ORM\Column(name: "CIN", type: "integer", nullable: false)]
    private int $cin;

    #[ORM\Column(name: "tel", type: "integer", nullable: false)]
    private int $tel;

    #[ORM\Column(name: "adresse_user", type: "string", length: 0, nullable: false)]
    private string $adresseUser;

    #[ORM\Column(name: "role_user", type: "string", length: 0, nullable: false)]
=======
    #[ORM\Column(name: "nom_user", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private string $nomUser;

    #[ORM\Column(name: "prenom_user", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private string $prenomUser;

    #[ORM\Column(name: "email_user", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    #[Assert\Email]
    private string $emailUser;

    #[ORM\Column(name: "mdp", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private string $mdp;

    #[ORM\Column(name: "salaire", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private float $salaire;

    #[ORM\Column(name: "date_naissance", type: "date", nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private \DateTime $dateNaissance;

    #[ORM\Column(name: "CIN", type: "integer", nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private int $cin;

    #[ORM\Column(name: "tel", type: "integer", nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private int $tel;

    #[ORM\Column(name: "adresse_user", type: "string", length: 0, nullable: false)]
    #[Assert\NotBlank(message:'empty field !')]
    private string $adresseUser;

    #[ORM\Column(name: "role_user", type: "string", length: 0, nullable: false)]
    #[Assert\NotBlank]
>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57
    private string $roleUser;

    #[ORM\Column(name: "numeric_code", type: "string", length: 255, nullable: true)]
    private ?string $numericCode;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Compte::class)]
    private Collection $comptes;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Credit::class)]
    private Collection $credits;

<<<<<<< HEAD
=======

>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57
    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->credits = new ArrayCollection();
    }

<<<<<<< HEAD
    public function getId(): ?int
    {
        return $this->id_user;
    }

=======
>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57
    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): static
    {
        $this->nomUser = $nomUser;
        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): static
    {
        $this->prenomUser = $prenomUser;
        return $this;
    }

    public function getEmailUser(): ?string
    {
        return $this->emailUser;
    }

    public function setEmailUser(string $emailUser): static
    {
        $this->emailUser = $emailUser;
        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;
        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): static
    {
        $this->salaire = $salaire;
        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): static
    {
        $this->cin = $cin;
        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): static
    {
        $this->tel = $tel;
        return $this;
    }

    public function getAdresseUser(): ?string
    {
        return $this->adresseUser;
    }

    public function setAdresseUser(string $adresseUser): static
    {
        $this->adresseUser = $adresseUser;
        return $this;
    }

<<<<<<< HEAD
    public function getRoleUser(): ?string
    {
        return $this->roleUser;
    }

=======
>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57
    public function setRoleUser(string $roleUser): static
    {
        $this->roleUser = $roleUser;
        return $this;
    }

    public function getNumericCode(): ?string
    {
        return $this->numericCode;
    }

    public function setNumericCode(?string $numericCode): static
    {
        $this->numericCode = $numericCode;
        return $this;
    }

    /**
     * @return Collection<int, Compte>
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): static
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes->add($compte);
            $compte->setUser($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): static
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getUser() === $this) {
                $compte->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Credit>
     */
    public function getCredits(): Collection
    {
        return $this->credits;
    }

    public function addCredit(Credit $credit): static
    {
        if (!$this->credits->contains($credit)) {
            $this->credits->add($credit);
            $credit->setUser($this);
        }

        return $this;
    }

    public function removeCredit(Credit $credit): static
    {
        if ($this->credits->removeElement($credit)) {
            // set the owning side to null (unless already changed)
            if ($credit->getUser() === $this) {
                $credit->setUser(null);
            }
        }

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

<<<<<<< HEAD
=======
    public function getUsername(): string
    {
        return $this->emailUser;
    }

    public function getRoles(): array
    {
        return [$this->roleUser];
    }

    public function getPassword(): string
    {
        return $this->mdp;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->emailUser;
    }

    public function getRoleUser()
    {
        return $this->roleUser;
    }

  

>>>>>>> a18cdd6a6674efbecf899883a1a5a485e854ff57
}
