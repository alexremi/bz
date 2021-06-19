<?php

namespace App\Mail;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Twig\Environment;

/**
 * Class NotificationMailManager.
 */
class NotificationMailManager extends AbstractMailManager
{
    /**
     * @param Environment     $twig
     * @param LoggerInterface $logger
     * @param string          $host
     * @param int             $port
     * @param string          $encryption
     * @param string          $defaultFromName
     * @param string          $gmailUsername
     * @param string          $gmailPassword
     */
    public function __construct(
        Environment $twig,
        LoggerInterface $logger,
        string $host,
        int $port,
        string $encryption,
        string $defaultFromName,
        string $gmailUsername,
        string $gmailPassword
    ) {
        parent::__construct($twig, $logger, $host, $port, $encryption, $defaultFromName, $gmailUsername, $gmailPassword);
    }

    /**
     * @param User  $user
     * @param array $context
     */
    public function sendRegistrationNotification(User $user, array $context): void
    {
        $emails = [$user->getEmail()];
        $this->send('mail/registration.html.twig', $context, $emails);
    }
}
