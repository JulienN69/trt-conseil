<?php

namespace App\Event;

use App\Entity\Announcement;
use Symfony\Contracts\EventDispatcher\Event;

final class NotifyEvent extends Event
{
    private string $jobName;

    public function __construct(Announcement $announcement)
    {
        $this->jobName = $announcement->getJobTitle();
    }

    public function getJobName()
    {
        return $this->jobName;
    }

}
