<?php

namespace App\Controller;

use App\Entity\Recruiter;
use App\Form\RecruiterType;
use App\Repository\RecruiterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecruiterController extends AbstractController
{
    #[Route('/recruiter/{id}', name: 'app_recruiter_{id}')]
    public function index(RecruiterRepository $repository, Request $request, Recruiter $recruiter, EntityManagerInterface $em): Response
    {
        $id = $request->get('id');
        $user = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(RecruiterType::class, $recruiter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'votre compte a bien été modifié.');
            return $this->redirectToRoute('app_recruiter_{id}', ['id' => $id]);
        }

        return $this->render('recruiter/index.html.twig', [
            'user' => $user,
            'recruiterForm' => $form
        ]);
    }
}
