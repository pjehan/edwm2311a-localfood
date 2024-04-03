<?php

namespace App\Scheduler\Handler;

use App\Repository\UserRepository;
use App\Scheduler\Message\CheckUserAccounts;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class CheckUserAccountsHandler
{
    public function __construct(private UserRepository $userRepository, private MailerInterface $mailer)
    {
    }

    public function __invoke(CheckUserAccounts $message)
    {
        $users = $this->userRepository->findInactiveUsers();
        $email = (new Email())
            ->from('no-reply@localfood.com')
            ->to('pierre.jehan@gmail.com')
            ->subject('Your account is inactive')
            ->text('Your account has been inactive for a year. Please log in to keep it active.');
        $this->mailer->send($email);
        foreach ($users as $user) {
            // send an email to the user
            $email = (new Email())
                ->from('no-reply@localfood.com')
                ->to($user->getEmail())
                ->subject('Your account is inactive')
                ->text('Your account has been inactive for a year. Please log in to keep it active.');
            $this->mailer->send($email);
        }
    }
}