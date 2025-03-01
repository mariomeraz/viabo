<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\tickets\ticket\find;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\find\CommerceIdQuery;
use Viabo\backoffice\company\application\find\CommerceQuery;
use Viabo\security\user\application\find\FindUserQuery;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\tickets\status\application\find\StatusQuery;
use Viabo\tickets\supportReason\application\find\SupportReasonQuery;
use Viabo\tickets\ticket\application\find\TicketsQuery;

final readonly class TicketsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $assigned = $request->query->getBoolean('assigned');
            $created = $request->query->getBoolean('created');

            $tickets = $this->ask(new TicketsQuery(
                $tokenData['id'] ,
                $tokenData['profileId'] ,
                $created ,
                $assigned
            ));

            $tickets = $this->additionalData($tickets->data , $created);
            
            if($tokenData['profileId'] === '3'){
                $tickets = $this->filterByAssigned($tickets , $assigned , $tokenData['id']);
            }
            
            return new JsonResponse($tickets);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }

    private function additionalData(array $tickets , bool $created): array
    {
        return array_map(function (array $ticket) use ($created) {
            $supportCause = $this->ask(new SupportReasonQuery($ticket['supportReasonId']));
            $status = $this->ask(new StatusQuery($ticket['statusId']));
            $user = $this->ask(new FindUserQuery($ticket['createdByUser'] , ''));
            $ticket['statusName'] = $status->data['name'];
            $ticket['applicantName'] = "{$user->data['name']} {$user->data['lastname']}";
            $ticket['supportReasonName'] = $supportCause->data['name'];
            $ticket['assignedName'] = $this->searchAssignedName($created , $ticket);

            return $ticket;
        } , $tickets);
    }

    function searchAssignedName(bool $created , array $ticket): string
    {
        $commerceAdminProfile = '3';
        $viaboAdminProfile = '2';

        if ($created && $ticket['assignedProfileId'] === $commerceAdminProfile) {
            $commerceId = $this->ask(new CommerceIdQuery(
                $ticket['createdByUser'] ,
                $ticket['applicantProfileId']
            ));
            $commerce = $this->ask(new CommerceQuery($commerceId->data));
            $user = $this->ask(new FindUserQuery($commerce->data['legalRepresentative'] , ''));
            return "{$user->data['name']} {$user->data['lastname']}";
        }

        if ($created && $ticket['assignedProfileId'] === $viaboAdminProfile) {
            return "Asistencia Viabo";
        }

        return '';
    }

    private function filterByAssigned(array $tickets , bool $assigned , string $userId): array
    {
        if ($assigned) {
            return array_filter($tickets , function (array $ticket) use ($userId) {
                $commerceId = $this->ask(new CommerceIdQuery(
                    $ticket['createdByUser'] ,
                    $ticket['applicantProfileId']
                ));
                $commerce = $this->ask(new CommerceQuery($commerceId->data));
                return $commerce->data['legalRepresentative'] === $userId;
            });
        }

        return $tickets;
    }

}