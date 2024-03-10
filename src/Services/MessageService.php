<?php

namespace App\Services;

use App\Dto\PosMessageDto;
use App\Entity\PosMessage;
use App\Repository\PosMessageRepository;
use Doctrine\ORM\EntityManagerInterface;

class MessageService
{
    public function __construct(private readonly PosMessageRepository $posMessageRepository,private readonly EntityManagerInterface $entityManager)
    {

    }

    public function register(PosMessageDto $posMessageDto): int
    {

        $posMessage = new PosMessage();
        $posMessage->setBody($posMessageDto->message);

        $this->entityManager->persist($posMessage);
        $this->entityManager->flush();

        return $posMessage->getId();
    }
}