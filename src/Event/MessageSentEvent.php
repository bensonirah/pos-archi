<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class MessageSentEvent extends Event
{
    const NAME = "message.sent";

    public function __construct(private readonly int $messageId)
    {
    }

    public static function fromId(int $messageId): MessageSentEvent
    {
        return new self($messageId);
    }
}