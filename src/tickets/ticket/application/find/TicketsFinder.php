<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\tickets\ticket\domain\exceptions\TicketsFindTypeHasTwoSelected;
use Viabo\tickets\ticket\domain\exceptions\TicketsFindTypeNotDefined;
use Viabo\tickets\ticket\domain\Ticket;
use Viabo\tickets\ticket\domain\TicketRepository;

final readonly class TicketsFinder
{
    public function __construct(private TicketRepository $repository)
    {
    }

    public function __invoke(
        string $userId ,
        string $userProfileId ,
        bool   $assigned ,
        bool   $created
    ): TicketResponse
    {

        $this->ensureFindType($assigned , $created);

        $filters = [];
        $tickets = [];
        $applicantProfile = '4';
        $commerceAdminProfile = '3';
        $viaboAdminProfile = '2';

        if ($created && ($userProfileId === $applicantProfile || $userProfileId === $commerceAdminProfile)) {
            $filters = [
                ['field' => 'createdByUser.value' , 'operator' => '=' , 'value' => $userId] ,
                ['field' => 'statusId.value' , 'operator' => 'NIN' , 'value' => '4']
            ];
        }

        if ($assigned && ($userProfileId === $commerceAdminProfile || $userProfileId === $viaboAdminProfile)) {
            $filters = [
                ['field' => 'assignedProfileId.value' , 'operator' => '=' , 'value' => $userProfileId] ,
                ['field' => 'statusId.value' , 'operator' => 'NIN' , 'value' => '3,4']
            ];
        }

        if (!empty($filters)) {
            $filters = Filters::fromValues($filters);
            $tickets = $this->repository->searchCriteria(new Criteria($filters));
        }

        return new TicketResponse(array_map(function (Ticket $ticket) {
            return $ticket->toArray();
        } , $tickets));
    }

    private function ensureFindType(bool $assigned , bool $created): void
    {
        if (!$assigned && !$created) {
            throw new TicketsFindTypeNotDefined();
        }

        if ($assigned && $created) {
            throw new TicketsFindTypeHasTwoSelected();
        }
    }
}