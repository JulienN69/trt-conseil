<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidateController extends AbstractController
{
    #[Route('/candidate/{id}', name: 'app_candidate_{id}')]
    public function index(CandidateRepository $repository, Request $request, Candidate $candidate, EntityManagerInterface $em): Response
    {
        $id = $request->get('id');
        $user = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(CandidateType::class, $candidate);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // $file = $form->get('curriculumVitae')->getData();
            // $fileName = $candidate->getId() . '.' . $file->getClientOriginalExtension();
            // $file->move($this->getParameter('kernel.project_dir') . '/public/images/cv', $fileName);
            // $candidate->setCurriculumVitae($fileName);

            $em->flush();
            $this->addFlash('success', 'votre compte a bien été modifié.');
            return $this->redirectToRoute('app_candidate_{id}', ['id' => $id]);
        }

        return $this->render('candidate/index.html.twig', [
            'user' => $user,
            'candidateForm' => $form
        ]);
    }
}
