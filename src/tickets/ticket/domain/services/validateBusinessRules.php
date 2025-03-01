<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain\services;


use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\tickets\ticket\domain\exceptions\ApplicantTicketLimitExceeded;
use Viabo\tickets\ticket\domain\exceptions\CommerceAdministratorTicketLimitExceeded;
use Viabo\tickets\ticket\domain\TicketRepository;

final readonly class validateBusinessRules
{
    public function __construct(private TicketRepository $repository)
    {
    }

    public function __invoke(string $userId , string $userProfileId): void
    {
        $this->checkApplicantTicketLimit($userId , $userProfileId);
    }

    private function checkApplicantTicketLimit(string $userId , string $userProfileId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'createdByUser.value' , 'operator' => '=' , 'value' => $userId] ,
            ['field' => 'statusId.value' , 'operator' => 'NIN' , 'value' => '3,4'] ,
        ]);
        $tickets = $this->repository->searchCriteria(new Criteria($filters));

        $applicantProfileId = '4';
        if (!empty($tickets) && count($tickets) >= 5 && $userProfileId === $applicantProfileId) {
            throw new ApplicantTicketLimitExceeded();
        }

        $commerceAdministrator = '3';
        if (!empty($tickets) && count($tickets) >= 10 && $userProfileId === $commerceAdministrator) {
            throw new CommerceAdministratorTicketLimitExceeded();
        }
    }

}