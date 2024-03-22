<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailSender
{
    public function sendUpdateNotification($entity, MailerInterface $mailer): void
    {
        try {
            $email = (new TemplatedEmail())
                ->from('strconseil@gmail.com')
                ->to($entity->getAnnouncement()->getRecruiter()->getUser()->getEmail())
                ->subject('Une candidature a été déposée')
                ->htmlTemplate('emails/test.html.twig')
                ->context([
                'username' => $entity->getAnnouncement()->getRecruiter()->getCompagnyName()
                    ]);

            $mailer->send($email);

        } catch (\Exception $e) {
            echo 'Une erreur est survenue lors de l\'envoi de l\'e-mail : ' . $e->getMessage();
        }

    }
}
