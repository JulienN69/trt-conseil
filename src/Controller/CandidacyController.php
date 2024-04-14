<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\Candidate;
use App\Entity\Announcement;
use App\Security\Voter\CandidateVoter;
use App\Repository\CandidacyRepository;
use App\Repository\CandidateRepository;
use App\Repository\AnnouncementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CandidacyController extends AbstractController
{
    #[Route('/candidacy', name: 'app_candidacy')]
    public function index(): Response
    {
        return $this->render('candidacy/index.html.twig', [
            'controller_name' => 'CandidacyController',
        ]);
    }

    #[Route('/create/{announcementId}/{candidateId}', name: 'app_candidacy_create')]
    // #[IsGranted(CandidateVoter::EDIT, subject: 'candidate')]
    public function create(
        CandidacyRepository $candidacyRepository,
        AnnouncementRepository $announcementRepository,
        CandidateRepository $candidateRepository,
        int $announcementId,
        int $candidateId
    ): Response 
    {

        $announcement = $announcementRepository->find($announcementId);
        $candidate = $candidateRepository->find($candidateId);

        if (!$announcement || !$candidate) {
            throw $this->createNotFoundException('L\'annonce ou le candidat n\'a pas été trouvé.');
        }

        $candidacyRepository->create($announcement, $candidate);
        $this->addFlash('success', 'Candidature prise en compte, elle sera envoyée à l\'entreprise après validation par nos équipes.');

        return $this->redirectToRoute('app_announcement');
    }
}
