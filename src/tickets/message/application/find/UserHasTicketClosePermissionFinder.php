<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\find;


use Viabo\tickets\message\domain\exceptions\MessageNotExist;
use Viabo\tickets\message\domain\MessageRepository;

final readonly class UserHasTicketClosePermissionFinder
{
    public function __construct(private MessageRepository $repository)
    {
    }

    public function __invoke(string $userId , string $ticketId): MessageResponse
    {
        $message = $this->repository->searchLast($ticketId);

        if (empty($message)) {
            throw new MessageNotExist();
        }

        return new MessageResponse(['userCanCloseTicket' => $message->hasTicketClosePermission($userId)]);
    }

}