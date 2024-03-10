<?php

namespace App\Controller;

use App\Dto\PosMessageDto;
use App\Event\MessageSentEvent;
use App\Services\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PosMessageController extends AbstractController
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,private readonly MessageService $messageService,
        private readonly SerializerInterface $serializer,private readonly ValidatorInterface $validator
    )
    {

    }

    #[Route('/pos/message', name: 'app_pos_message',methods: 'POST|GET')]
    public function index(Request $request): Response
    {
        if (!$request->isMethod('POST')){
            return $this->render('pos_message/index.html.twig', [
                'controller_name' => 'PosMessageController',
                'message' => null
            ]);
        }

        $posMessageDto = $this->serializer->deserialize(
            json_encode($request->request->all()),PosMessageDto::class,'json'
        );
        $errors = $this->validator->validate($posMessageDto);
        if (count($errors)>0) {
            dd($errors);
        }
        $posMessageId = $this->messageService->register($posMessageDto);
        $this->eventDispatcher->dispatch(MessageSentEvent::fromId($posMessageId));

        return $this->render('pos_message/index.html.twig', [
            'controller_name' => 'PosMessageController',
            'message' => $posMessageDto->message
        ]);
    }
}
