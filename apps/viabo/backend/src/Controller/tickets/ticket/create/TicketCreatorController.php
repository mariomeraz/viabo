<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\tickets\ticket\create;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\find\AddUsersEmailsQuery;
use Viabo\security\user\application\find\UsersQueryByProfile;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\tickets\message\application\create\CreateMessageCommand;
use Viabo\tickets\supportReason\application\find\SupportReasonQuery;
use Viabo\tickets\ticket\application\create\CreateTicketCommand;
use Viabo\tickets\ticket\application\find\TicketNewIdQuery;

final readonly class TicketCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $supportReasonId = $request->request->getString('supportReasonId');
            $description = $request->request->getString('description');
            $uploadFiles = $request->files->all();
            $ticketId = $this->ask(new TicketNewIdQuery());
            $messageId = $this->generateUuid();
            $supportReason = $this->ask(new SupportReasonQuery($supportReasonId));

            $this->dispatch(new CreateTicketCommand(
                $tokenData['id'] ,
                $tokenData['profileId'] ,
                $ticketId->data['id'] ,
                $supportReason->data['id'] ,
                $supportReason->data['assignedProfileId'] ,
                $description
            ));

            $this->dispatch(new CreateMessageCommand(
                $tokenData['id'] ,
                $messageId ,
                $ticketId->data['id'] ,
                $description ,
                $uploadFiles
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}