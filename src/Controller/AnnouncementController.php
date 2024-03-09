<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use App\Repository\RecruiterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnouncementController extends AbstractController
{
    #[Route('/announcement', name: 'app_announcement')]
    public function index(AnnouncementRepository $announcementRepo): Response
    {
        $announcements = $announcementRepo->findAll();

        return $this->render('announcement/index.html.twig', [
            'controller_name' => 'AnnouncementController',
            'announcements' => $announcements
        ]);
    }


    #[Route('/announcement_create/{id}', name: 'app_announcement_create_{id}')]
    public function create(Request $request, EntityManagerInterface $em, int $id, RecruiterRepository $recruiterRepo): Response
    {
        $recruiter = $recruiterRepo->find($id);
        $Announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $Announcement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Announcement->setRecruiter($recruiter);
            $em->persist($Announcement);
            $em->flush();
            $this->addFlash('success', 'annonce créée, elle sera affichée après validation par nos modérateurs.');
            return $this->redirectToRoute('app_announcement_create_{id}', ['id' => $id]);
        }

        return $this->render('announcement/create.html.twig', [
            'AnnouncementForm' => $form,
        ]);
    }

}
