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
    public function index(AnnouncementRepository $announcementRepo, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $announcements = $announcementRepo->paginateAnnouncement($page, $limit);
        $maxPage = ceil($announcements->getTotalItemCount()/ $limit);

        // $announcements = $announcementRepo->findAll();

        return $this->render('announcement/index.html.twig', [
            'controller_name' => 'AnnouncementController',
            'announcements' => $announcements,
            'maxPage' => $maxPage,
            'page' => $page
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
    
    #[Route('/announcement_show/{id}', name: 'app_announcement_show_{id}')]
    public function show(int $id, RecruiterRepository $recruiterRepo, AnnouncementRepository $announcementRepo): Response
    {

        $announcements = $announcementRepo->findAllAnnoucementByRecruiterId($id, $recruiterRepo);

        return $this->render('announcement/show.html.twig', [
            'announcements' => $announcements,
        ]);
    }
}
