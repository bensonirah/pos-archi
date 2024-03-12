<?php

namespace App\Controller;

use App\Dto\PosMessageDto;
use App\Event\MessageSentEvent;
use App\Services\MessageService;
use Psr\Log\LoggerInterface;
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
        private readonly EventDispatcherInterface $eventDispatcher, private readonly MessageService $messageService,
        private readonly SerializerInterface      $serializer, private readonly ValidatorInterface $validator,
        private readonly LoggerInterface          $posLogger
    )
    {

    }

    #[Route('/pos/message', name: 'app_pos_message', methods: 'POST|GET')]
    public function index(Request $request): Response
    {
        if (!$request->isMethod('POST')) {
            return $this->render('pos_message/index.html.twig', [
                'controller_name' => 'PosMessageController',
                'message' => null,
                'hasError' => false,
                'errorMessage' => null
            ]);
        }
        // Transformer le contenu d'une http request en un Dto avec le Serializer de Symfony
        $posMessageDto = $this->serializer->deserialize(
            json_encode($request->request->all()), PosMessageDto::class, 'json'
        );
        // Valider l'input encapsuler dans un dto à partir de validator de Symfony
        $errors = $this->validator->validate($posMessageDto);

        if ($errors->count() > 0) {
            // Logger l'erreur dans le fichier de log dédié pos-recette.log, pos-dev.log, etc
            $this->posLogger->error('Erreur message', ['error' => $errors[0]]);
            // Retourner l'erreur vers le client s'il y en a
            $this->render('pos_message/index.html.twig', [
                'controller_name' => 'PosMessageController',
                'message' => $errors[0],
                'hasError' => true,
            ]);
        }
        // Delegation par service
        $posMessageId = $this->messageService->register($posMessageDto);
        // Envoi de l'event dans un bus de subscriber pour traiter les differents effets de bords (notification push, sms et email)
        $this->eventDispatcher->dispatch(MessageSentEvent::fromId($posMessageId));

        return $this->render('pos_message/index.html.twig', [
            'controller_name' => 'PosMessageController',
            'message' => $posMessageDto->message,
            'hasError' => false,
        ]);
    }
}
