<?php

namespace App\Services\Factory;

use App\Dto\PosMessageDto;
use App\Entity\PosMessage;

final class RegisterPosMessageFactory
{
    public static function fromDto(PosMessageDto $dto): PosMessage
    {
        $posMessage = new PosMessage();
        $posMessage->setBody($dto->message);
        return $posMessage;
    }
}