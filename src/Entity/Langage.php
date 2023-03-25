<?php

namespace App\Entity;

use App\Repository\LangageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: LangageRepository::class)]
class Langage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $nom;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $image;

    #[ORM\ManyToMany(targetEntity:Developpeur::class, mappedBy:"langages")]
    private Collection $developpeurs;

    public function __construct()
    {
        $this->developpeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDeveloppeurs(): Collection
    {
        return $this->developpeurs;
    }

    public function addDeveloppeur(Developpeur $developpeur): self
    {
        if (!$this->developpeurs->contains($developpeur)) {
            $this->developpeurs[] = $developpeur;
            $developpeur->addLangage($this);
        }

        return $this;
    }

    public function removeDeveloppeur(Developpeur $developpeur): self
    {
        if ($this->developpeurs->removeElement($developpeur)) {
            $developpeur->removeLangage($this);
        }

        return $this;
    }
}
