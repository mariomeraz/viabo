<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\tickets\message\find;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\find\FindUserQuery;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\tickets\message\application\find\MessagesQuery;
use Viabo\tickets\message\application\find\UserHasTicketClosePermissionQuery;

final readonly class MessagesFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $ticket = $request->query->getString('ticket');
            $limit = $request->query->getInt('limit');
            $page = $request->query->getInt('page');

            $messages = $this->ask(new MessagesQuery(
                $tokenData['id'] ,
                $tokenData['profileId'] ,
                $ticket ,
                $limit ,
                $page
            ));
            $messages = $this->addAdditionalData($messages->data , $tokenData['id'] , $ticket);

            return new JsonResponse($messages);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }

    private function addAdditionalData(array $messages , string $userId , string $ticket): array
    {
        $messages['messages'] = array_map(function (array $message) {
            $user = $this->ask(new FindUserQuery($message['createdByUser'] , ''));
            $message['userName'] = "{$user->data['name']} {$user->data['lastname']}";
            $message['files'] = array_map(fn(array $file) => $file['storagePath'] , $message['files']);
            return $message;
        } , $messages['messages']);

        $response = $this->ask(new UserHasTicketClosePermissionQuery($userId , $ticket));
        $messages['userCanCloseTicket'] = $response->data['userCanCloseTicket'];
        return $messages;
    }

}