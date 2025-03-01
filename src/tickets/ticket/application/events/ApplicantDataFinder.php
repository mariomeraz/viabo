<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\events;


use Viabo\security\user\application\find\FindUserQuery;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\tickets\ticket\domain\events\TicketClosedDomainEvent;

final readonly class ApplicantDataFinder
{
    public function __construct(
        private QueryBus $queryBus ,
        private EventBus $bus
    )
    {
    }

    public function __invoke(array $ticket): void
    {
        $userId = $ticket['createdByUser'];
        $user = $this->searchApplicantData($userId);
        $ticket = array_merge($ticket , $user);

        $this->bus->publish(new TicketClosedDomainEvent($ticket['id'] , $ticket));
    }

    private function searchApplicantData(string $userId): array
    {
        $user = $this->queryBus->ask(new FindUserQuery($userId , ''));
        return [
            'applicantName' => $user->data['name'] ,
            'applicantLastName' => $user->data['lastname'] ,
            'email' => [$user->data['email']]
        ];
    }
}