<?php

namespace App\Controller\Admin;

use App\Entity\Candidacy;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CandidacyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidacy::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()->hideOnIndex();
        yield AssociationField::new('candidate')
        ->hideOnForm() 
        ->setLabel('Candidat')
        ->formatValue(function ($value, $entity) {
            return $value->getFirstName() . ' ' . $value->getLastName();
        });
        yield AssociationField::new('announcement')
        ->hideOnForm()
        ->setLabel('Offre d\'emploi')
        ->formatValue(function ($value, $entity) {
            return $value->getJobTitle();
        });
        yield BooleanField::new('isValid')->setLabel('Candidature valide ?');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des candidatures');
    }

}
