<?php

namespace App\EventSubscriber;

use App\Event\MessageSentEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class OnMessageSentSubscriber implements EventSubscriberInterface
{
    private MailerInterface $mailer;
    private LoggerInterface $posLogger;

    /**
     * @param MailerInterface $mailer
     * @param LoggerInterface $posLogger
     */
    public function __construct(MailerInterface $mailer, LoggerInterface $posLogger)
    {
        $this->mailer = $mailer;
        $this->posLogger = $posLogger;
    }

    public function onMessageSent(MessageSentEvent $event): void
    {
        // Envoi de notification mail
        // Ici le service d'envoi mail est bien découplé du service metier
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->posLogger->error('Erreur envoi email notification', $e->getTrace());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MessageSentEvent::NAME => 'onMessageSent',
        ];
    }
}
