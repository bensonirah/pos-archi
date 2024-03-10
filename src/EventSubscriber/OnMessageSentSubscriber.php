<?php

namespace App\EventSubscriber;

use App\Event\MessageSentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OnMessageSentSubscriber implements EventSubscriberInterface
{
    public function onMessageSent(MessageSentEvent $event): void
    {
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MessageSentEvent::NAME => 'onMessageSent',
        ];
    }
}
