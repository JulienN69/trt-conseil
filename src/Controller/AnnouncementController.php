<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementController extends AbstractController
{
    #[Route('/announcement', name: 'app_announcement')]
    public function index(): Response
    {
        return $this->render('announcement/index.html.twig', [
            'controller_name' => 'AnnouncementController',
        ]);
    }

    #[Route('/announcement_create', name: 'app_announcement_create')]
    public function create(Request $request, EntityManagerInterface $em, Announcement $Announcement): Response
    {
        
        $form = $this->createForm(AnnouncementType::class, $Announcement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            // dd($form->getData());

            // $unitOfWork = $em->getUnitOfWork();
            // $entitiesToPersist = $unitOfWork->getScheduledEntityInsertions();
            // dd($entitiesToPersist);
            $em->persist($Announcement);

            $em->flush();
            $this->addFlash('success', 'annonce créée, elle sera affichée après validation par nos modérateurs.');
            return $this->redirectToRoute('app_announcement_create');
        }

        return $this->render('announcement/create.html.twig', [
            'AnnouncementForm' => $form,
        ]);
    }
}
