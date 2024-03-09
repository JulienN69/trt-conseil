<?php

namespace App\Form;

use App\Entity\Announcement;
use App\Entity\Candidacy;
use App\Entity\Recruiter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jobTitle', null, [
                'label' => 'Intitulé du poste'
            ])
            ->add('workPlace', null, [
                'label' => 'Lieu'
            ])
            ->add('description');
            // ->add('recruiter', EntityType::class, [
            //     'class' => Recruiter::class,
            //     'choice_label' => 'id',
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
