<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\events;


use Viabo\security\user\application\find\FindUserQuery;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\tickets\message\domain\events\MessageAdditionalDataFoundDomainEvent;
use Viabo\tickets\ticket\application\find\TicketQuery;

final readonly class MessageAdditionalDataFinder
{
    public function __construct(private QueryBus $queryBus , private EventBus $bus)
    {
    }

    public function __invoke(array $message): void
    {
        $ticket = $this->queryBus->ask(new TicketQuery($message['ticketId']));
        $messageUser = $this->queryBus->ask(new FindUserQuery($message['createdByUser'] , ''));
        $applicant = $this->queryBus->ask(new FindUserQuery($ticket->data['createdByUser'] , ''));
        $messageUserProfileId = $messageUser->data['profile'];
        $applicantProfileId = $ticket->data['applicantProfileId'];
        $message['userName'] = "{$messageUser->data['name']} {$messageUser->data['lastname']}";
        $message['emails'] = [$applicant->data['email']];

        if ($applicantProfileId != $messageUserProfileId) {
            $this->bus->publish(new MessageAdditionalDataFoundDomainEvent($message['id'] , $message));
        }
    }
}