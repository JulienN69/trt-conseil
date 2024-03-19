<?php

namespace App\EventListener;

use App\Entity\Candidacy;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\EmailSender;

final class ValidationListener
{
    private $mailer;
    private $emailSender;

    public function __construct(MailerInterface $mailer, EmailSender $emailSender)
    {
        $this->mailer = $mailer;
        $this->emailSender = $emailSender;
    }

    #[AsEventListener(event: AfterEntityUpdatedEvent::class)]
    public function onAfterEntityUpdatedEvent(AfterEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Candidacy) {
            return; // Ne rien faire si l'entité n'est pas une Candidacy
        }

        $isValid = $entity->isIsValid();

        if ($isValid !== false) {
            $this->emailSender->sendUpdateNotification($entity, $this->mailer);
        }
            
    }
}
