<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->passwordEncoder = $userPasswordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()->hideOnIndex();
        yield TextField::new('email')->setLabel('Email');        
        yield TextField::new('password')
        ->setLabel('Password')
        ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => '(Repeat)'],
            ])
            ->onlyOnForms();
        yield ChoiceField::new('roles')
            ->setLabel('Roles')
            ->allowMultipleChoices(true)
            ->setChoices([
                'Admin' => 'ROLE_ADMIN',
                'Modérateur' => 'ROLE_MODERATEUR',
                'Utilisateur' => 'ROLE_USER'
            ]);     
    }

    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Hasher le mot de passe avant la persistance
        $entityInstance->setPassword(
            $this->passwordEncoder->hashPassword($entityInstance, $entityInstance->getPassword())
        );

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Hasher le mot de passe avant la mise à jour
        $entityInstance->setPassword(
            $this->passwordEncoder->hashPassword($entityInstance, $entityInstance->getPassword())
        );

        parent::updateEntity($entityManager, $entityInstance);
    }

}
