<?php

namespace App\EventSubscriber;

use App\Event\NotifyEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;

class NotifySubscriber implements EventSubscriberInterface
{   
    private $requestStack;
    
    public function __construct(RequestStack $requestStack){
        $this->requestStack = $requestStack;
    }

    public function onNotifyEvent(NotifyEvent $event): void
    {
        $jobName = $event->getJobName();
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        if ($session instanceof FlashBagAwareSessionInterface) {
            $session->getFlashBag()->add('success', 'votre offre d\'emploi "' . $jobName . ' "a été créée.');
        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            NotifyEvent::class => 'onNotifyEvent',
        ];
    }
}

