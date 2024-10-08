<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\CandidacyRepository;

#[ORM\Entity(repositoryClass: CandidacyRepository::class)]
class Candidacy
{
    // use EntityIdTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\ManyToOne(inversedBy: 'candidacies')]
    private ?Candidate $candidate = null;

    #[ORM\ManyToOne(inversedBy: 'candidacies')]
    private ?Announcement $announcement = null;


    public function __construct()
    {
        $this->isValid = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        if ($this->isValid === false && $isValid === true) {
        }

        $this->isValid = $isValid;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): static
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getAnnouncement(): ?Announcement
    {
        return $this->announcement;
    }

    public function setAnnouncement(?Announcement $announcement): static
    {
        $this->announcement = $announcement;

        return $this;
    }

}
