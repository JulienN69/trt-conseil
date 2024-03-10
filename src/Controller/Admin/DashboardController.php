<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Candidacy;
use App\Entity\Candidate;
use App\Entity\Recruiter;
use App\Entity\Announcement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TRT Conseil');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Candidatures', 'fa-solid fa-briefcase', Candidacy::class);
        yield MenuItem::linkToCrud('Candidats', 'fa-solid fa-user', Candidate::class);
        yield MenuItem::linkToCrud('Recruteurs', 'fa-solid fa-building', Recruiter::class);
        yield MenuItem::linkToCrud('Offre d\'emploi', 'fa-solid fa-scroll', Announcement::class);
        yield MenuItem::linkToCrud('utilisateur', 'fa-solid fa-user', User::class);
    }
}
