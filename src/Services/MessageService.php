<?php

namespace App\Services;

use App\Dto\PosMessageDto;
use App\Entity\PosMessage;
use App\Exception\PosMessageNotFoundException;
use App\Repository\PosMessageRepository;
use App\Services\Factory\RegisterPosMessageFactory;
use Doctrine\ORM\EntityManagerInterface;

class MessageService
{
    public function __construct(private readonly PosMessageRepository $posMessageRepository, private readonly EntityManagerInterface $entityManager)
    {

    }

    /**
     * @param PosMessageDto $posMessageDto
     * @return int
     */
    public function register(PosMessageDto $posMessageDto): int
    {

        $posMessage = RegisterPosMessageFactory::fromDto($posMessageDto);
        $this->entityManager->persist($posMessage);
        $this->entityManager->flush();

        return $posMessage->getId();
    }

    /**
     * @param int $posMessageId
     * @return PosMessage
     * @throws PosMessageNotFoundException
     */
    public function getPosMessageById(int $posMessageId): PosMessage
    {
        if (!$posMessage = $this->posMessageRepository->find($posMessageId)) {
            throw new PosMessageNotFoundException();
        }
        return $posMessage;
    }

    /**
     * @param int $posMessageId
     * @return PosMessage|null
     */
    public function findPosMessageById(int $posMessageId): ?PosMessage
    {
        return $this->posMessageRepository->find($posMessageId);
    }
}