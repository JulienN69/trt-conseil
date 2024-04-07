<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\AnnouncementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnnouncementRepository::class)]
class Announcement
{
    // use EntityIdTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length([
        'min' => 2,
        'max' => 100,
        'minMessage' => 'L\'intitulé doit faire au moins {{ limit }} charactères',
        'maxMessage' => 'L\'intitulé doit faire au maximum {{ limit }} charactères',
    ])]
    private ?string $jobTitle = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length([
        'min' => 5,
        'max' => 100,
        'minMessage' => 'L\'adresse doit faire au moins {{ limit }} charactères',
        'maxMessage' => 'L\'adresse doit faire au maximum {{ limit }} charactères',
    ])]
    private ?string $workPlace = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length([
        'min' => 10,
        'max' => 500,
        'minMessage' => 'La description doit faire au moins {{ limit }} charactères',
        'maxMessage' => 'La description doit faire au maximum {{ limit }} charactères',
    ])]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\ManyToOne(inversedBy: 'announcements')]
    private ?Recruiter $recruiter = null;

    #[ORM\OneToMany(targetEntity: Candidacy::class, mappedBy: 'announcement')]
    private Collection $candidacies;

    public function __construct()
    {
        $this->isValid = false;
        $this->candidacies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getWorkPlace(): ?string
    {
        return $this->workPlace;
    }

    public function setWorkPlace(string $workPlace): static
    {
        $this->workPlace = $workPlace;

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

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getRecruiter(): ?Recruiter
    {
        return $this->recruiter;
    }

    public function setRecruiter(?Recruiter $recruiter): static
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * @return Collection<int, Candidacy>
     */
    public function getCandidacies(): Collection
    {
        return $this->candidacies;
    }

    public function addCandidacy(Candidacy $candidacy): static
    {
        if (!$this->candidacies->contains($candidacy)) {
            $this->candidacies->add($candidacy);
            $candidacy->setAnnouncement($this);
        }

        return $this;
    }

    public function removeCandidacy(Candidacy $candidacy): static
    {
        if ($this->candidacies->removeElement($candidacy)) {
            // set the owning side to null (unless already changed)
            if ($candidacy->getAnnouncement() === $this) {
                $candidacy->setAnnouncement(null);
            }
        }

        return $this;
    }
}
