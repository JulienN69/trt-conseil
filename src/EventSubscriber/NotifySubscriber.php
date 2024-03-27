<?php

namespace App\EventSubscriber;

use App\Event\NotifyEvent;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;

class NotifySubscriber implements EventSubscriberInterface
{   
    public function __construct(private NotifierInterface $notifier) 
    {

    }

    public function onNotifyEvent(NotifyEvent $event): void
    {
        $jobName = $event->getJobName();
        $content = 'Votre annonce ' . $jobName . ' a bien été créée, elle sera affiché après validation par nos équipes.';


        $notification = (new Notification($content, ['browser']));

        
        $this->notifier->send($notification);
    }

    // private $requestStack;
    
    // public function __construct(RequestStack $requestStack){
    //     $this->requestStack = $requestStack;
    // }

    // public function onNotifyEvent(NotifyEvent $event): void
    // {
    //     $jobName = $event->getJobName();
    //     $request = $this->requestStack->getCurrentRequest();
    //     $session = $request->getSession();
    //     if ($session instanceof FlashBagAwareSessionInterface) {
    //         $session->getFlashBag()->add('success', 'votre offre d\'emploi "' . $jobName . ' "a été créée.');
    //     }

    // }

    public static function getSubscribedEvents(): array
    {
        return [
            NotifyEvent::class => 'onNotifyEvent',
        ];
    }
}

