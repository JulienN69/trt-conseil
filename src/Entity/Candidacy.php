<?php

namespace App\Entity;

use App\Repository\CandidacyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidacyRepository::class)]
class Candidacy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\OneToOne(inversedBy: 'idJobOffer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidate $idCandidate = null;

    #[ORM\OneToOne(inversedBy: 'candidacy', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?JobOffer $idJobOffer = null;

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
        $this->isValid = $isValid;

        return $this;
    }

    public function getIdCandidate(): ?Candidate
    {
        return $this->idCandidate;
    }

    public function setIdCandidate(Candidate $idCandidate): static
    {
        $this->idCandidate = $idCandidate;

        return $this;
    }

    public function getIdJobOffer(): ?jobOffer
    {
        return $this->idJobOffer;
    }

    public function setIdJobOffer(jobOffer $idJobOffer): static
    {
        $this->idJobOffer = $idJobOffer;

        return $this;
    }
}
