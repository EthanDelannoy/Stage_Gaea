<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('user:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $tel = null;

    /**
     * @var Collection<int, Possession>
     */
    #[ORM\OneToMany(targetEntity: Possession::class, mappedBy: 'user', orphanRemoval: true)]
    #[Groups('user:read')]
    private Collection $possessions;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('user:read')]
    #[SerializedName('birthDate')]
    private ?\DateTimeInterface $birthDate = null;
    
    public function __construct()
    {
        $this->possessions = new ArrayCollection();
    }

    #[Groups('user:read')]
    public function getAge(): int
    {    
        $date = new \DateTime();
        return $date->diff($this->birthDate)->y;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection<int, Possession>
     */
    public function getPossessions(): Collection
    {
        return $this->possessions;
    }

    public function addPossession(Possession $possession): static
    {
        if (!$this->possessions->contains($possession)) {
            $this->possessions->add($possession);
            $possession->setUser($this);
        }

        return $this;
    }

    public function removePossession(Possession $possession): static
    {
        if ($this->possessions->removeElement($possession)) {
            // set the owning side to null (unless already changed)
            if ($possession->getUser() === $this) {
                $possession->setUser(null);
            }
        }

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }
}
