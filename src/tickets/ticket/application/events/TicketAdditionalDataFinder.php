<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\events;


use Viabo\backoffice\company\application\find\CommerceIdQuery;
use Viabo\backoffice\company\application\find\CommerceQuery;
use Viabo\security\user\application\find\FindUserQuery;
use Viabo\security\user\application\find\UsersQueryByProfile;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\tickets\ticket\domain\events\TicketEmailsFoundDomainEvent;

final readonly class TicketAdditionalDataFinder
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
        $profileId = $ticket['applicantProfileId'];
        $emails = [];

        $applicantProfile = '4';
        if ($profileId === $applicantProfile) {
            $emails = $this->searchCommerceAdminEmail($userId , $profileId);
        }

        $commerceAdminProfile = '3';
        if ($profileId === $commerceAdminProfile) {
            $emails = $this->searchViaboAdminsEmails($ticket['assignedProfileId']);
        }

        $user = $this->searchApplicantData($userId);
        $ticket = $this->merge($ticket , $emails , $user);

        $this->bus->publish(new TicketEmailsFoundDomainEvent($ticket['id'] , $ticket));
    }

    private function searchCommerceAdminEmail(string $userId , string $profileId): array
    {
        $commerceId = $this->queryBus->ask(new CommerceIdQuery($userId , $profileId));
        $commerce = $this->queryBus->ask(new CommerceQuery($commerceId->data));
        $commerceAdmin = $this->queryBus->ask(new FindUserQuery($commerce->data['legalRepresentative'] , ''));
        return ['emails' => [$commerceAdmin->data['email']]];
    }

    private function searchApplicantData(string $userId): array
    {
        $user = $this->queryBus->ask(new FindUserQuery($userId , ''));
        return ['applicantName' => $user->data['name'] , 'applicantLastName' => $user->data['lastname']];
    }

    private function searchViaboAdminsEmails(string $userProfileId): array
    {
        $admins = $this->queryBus->ask(new UsersQueryByProfile($userProfileId));
        $emails = array_map(function (array $admin) {
            return $admin['email'];
        } , $admins->data);
        return ['emails' => $emails];
    }

    private function merge(array $ticket , array $emails , array $user): array
    {
        return array_merge($ticket , $user , $emails);
    }
}