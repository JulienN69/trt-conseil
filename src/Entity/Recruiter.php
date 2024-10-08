<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\RecruiterRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecruiterRepository::class)]
class Recruiter
{
    use EntityIdTrait;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length([
        'min' => 2,
        'max' => 255,
        'minMessage' => 'Le nom doit faire au moins {{ limit }} charactères',
        'maxMessage' => 'Le nom doit faire au maximum {{ limit }} charactères',
    ])]
    private ?string $compagnyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length([
        'min' => 5,
        'max' => 255,
        'minMessage' => 'L\'adresse doit faire au moins {{ limit }} charactères',
        'maxMessage' => 'L\'adresse doit faire au maximum {{ limit }} charactères',
    ])]
    private ?string $adress = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\OneToOne(inversedBy: 'recruiter', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Announcement::class, mappedBy: 'recruiter')]
    private Collection $announcements;

    

    public function __construct()
    {
        $this->isValid = false;
        $this->announcements = new ArrayCollection();
    }

    public function getCompagnyName(): ?string
    {
        return $this->compagnyName;
    }

    public function setCompagnyName(string $compagnyName): static
    {
        $this->compagnyName = $compagnyName;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        $this->isValid = $isValid;

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

    /**
     * @return Collection<int, Announcement>
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): static
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements->add($announcement);
            $announcement->setRecruiter($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): static
    {
        if ($this->announcements->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getRecruiter() === $this) {
                $announcement->setRecruiter(null);
            }
        }

        return $this;
    }

}
