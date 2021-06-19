<?php

namespace App\Mail;

use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Throwable;
use Twig\Environment;

/**
 * Class AbstractMailManager.
 */
abstract class AbstractMailManager
{
    /**
     * @var Environment
     */
    protected Environment $twig;

    /**
     * @var string
     */
    protected string $host;

    /**
     * @var int
     */
    protected int $port;

    /**
     * @var string
     */
    protected string $encryption;

    /**
     * @var string
     */
    protected string $defaultFromName;

    /**
     * @var string
     */
    protected string $gmailUsername;

    /**
     * @var string
     */
    protected string $gmailPassword;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

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
        $this->twig            = $twig;
        $this->logger          = $logger;
        $this->host            = $host;
        $this->port            = $port;
        $this->encryption      = $encryption;
        $this->defaultFromName = $defaultFromName;
        $this->gmailUsername   = $gmailUsername;
        $this->gmailPassword   = $gmailPassword;
    }

    /**
     * Send email.
     *
     * @param string      $templateName
     * @param array       $context
     * @param array       $toEmail
     * @param string|null $fromEmail
     */
    public function send(string $templateName, array $context, array $toEmail, ?string $fromEmail = null): void
    {
        try {
            $template = $this->twig->load($templateName);
            $subject  = $template->renderBlock('subject', $context);
            $textBody = $template->renderBlock('body_text', $context);
            $htmlBody = $template->renderBlock('body_html', $context);

            $transport = (new Swift_SmtpTransport($this->host, $this->port, $this->encryption))
                ->setUsername($this->gmailUsername)
                ->setPassword($this->gmailPassword)
            ;

            $mailer = new Swift_Mailer($transport);

            /** @var Swift_Message $message */
            $message = $mailer
                ->createMessage()
                ->setSubject($subject)
                ->setTo($toEmail)
                ->setFrom($fromEmail ?? [$this->gmailUsername => $this->defaultFromName])
            ;

            if (!empty($htmlBody)) {
                $message
                    ->setBody($htmlBody, 'text/html')
                    ->addPart($textBody, 'text/plain')
                ;
            } else {
                $message->setBody($textBody);
            }

            $mailer->send($message);

        } catch (Throwable $e) {
            $this->logger->critical("Sending email failed: {$e->getMessage()}");
        }
    }
}
