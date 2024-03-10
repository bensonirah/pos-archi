<?php

namespace App\Dto;

use App\Validator\Message;

final class PosMessageDto
{
    #[Message()]
    public string $message;
}