<?php
// src/Scheduler/CheckUserAccountsProvider.php

namespace App\Scheduler;

use App\Scheduler\Message\CheckUserAccounts;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule('check_user_accounts')]
class CheckUserAccountsProvider implements ScheduleProviderInterface
{

    private Schedule $schedule;

    public function getSchedule(): Schedule
    {
        if  (!isset($this->schedule)) {
            $schedule = new Schedule();
            $schedule->add(RecurringMessage::every('1 minute', new CheckUserAccounts()));
            $this->schedule = $schedule;
        }

        return $this->schedule;
    }
}