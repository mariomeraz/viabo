<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\tickets\message\create;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\tickets\message\application\create\CreateMessageCommand;

final readonly class MessageCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $ticketId = $request->request->getString('ticketId');
            $message = $request->request->getString('message');
            $uploadFiles = $request->files->all();
            $messageId = $this->generateUuid();

            $this->dispatch(new CreateMessageCommand(
                $tokenData['id'] ,
                $messageId ,
                $ticketId ,
                $message ,
                $uploadFiles
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}