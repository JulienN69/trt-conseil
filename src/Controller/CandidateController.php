<?php

namespace App\Controller;

use Exception;
use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Security\Voter\CandidateVoter;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CandidateController extends AbstractController
{
    #[Route('/candidate/{id}', name: 'app_candidate_{id}')]
    #[IsGranted(CandidateVoter::EDIT, subject: 'candidate')]
    public function index(CandidateRepository $repository, Request $request, Candidate $candidate, EntityManagerInterface $em): Response
    {
        $id = $request->get('id');
        $user = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(CandidateType::class, $candidate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $CVFile = $candidate->getCurriculumVitae();

            // Vérifier si un fichier existe déjà
            if ($CVFile != null) {
                $filePath = $this->getParameter('kernel.project_dir') . '/public/images/cv/' . $CVFile;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $uploadedFile = $form['curriculumVitaeFile']->getData();


            if ($uploadedFile instanceof UploadedFile) {

                $destination = $this->getParameter('kernel.project_dir') . '/public/images/cv';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                try {
                    $uploadedFile->move($destination, $newFilename);
                } catch (FileException $e) {
                    throw New Exception('erreur lors de l\'envoi du fichier');
                }

                $candidate->setCurriculumVitae($newFilename);
            }

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
