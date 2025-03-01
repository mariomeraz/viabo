<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\users\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company\CompanyQuery;
use Viabo\backoffice\services\application\find_service_by_card_cloud_subAccount\ServiceCardCloudQueryBySubAccount;
use Viabo\backoffice\users\application\assign_user_in_company\AssignUserCommandInCompany;
use Viabo\cardCloud\users\application\assign_cards_in_user\AssignCardsCommandInUser;
use Viabo\cardCloud\users\application\find_user_by_card\CardCloudUserQuery;
use Viabo\cardCloud\users\application\update_user_email_by_cardholder\UpdateCardCloudUserEmailCommand;
use Viabo\security\user\application\create_user_by_assign_card_cloud\CreateUserCardCloudOwnerCommand;
use Viabo\security\user\application\find\UserQueryByUsername;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardToHolderAssignmentController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $data = $request->toArray();
            $data['cards'] = [$data['card']];

            $user = $this->ask(new CardCloudUserQuery($data['card']));
            if (!empty($user->data['isPending'])) {
                $this->dispatch(new UpdateCardCloudUserEmailCommand($user->data['ownerId'], $data['email']));
            } else {
                $user = $this->searchUser($data['email']);
                $this->ensureUserProfile($user);

                $data['user'] = empty($user) ? '' : $user['id'];
                $service = $this->ask(new ServiceCardCloudQueryBySubAccount($data['subAccount']));
                $company = $this->ask(new CompanyQuery($service->data['companyId']));
                $businessId = $company->data['businessId'];

                if (empty($user)) {
                    $data['user'] = $this->generateUuid();
                    $this->dispatch(new CreateUserCardCloudOwnerCommand($businessId, $data['user'], $data));
                    $this->dispatch(new AssignUserCommandInCompany($businessId, $company->data['id'], $data['user']));
                }

                $this->dispatch(new AssignCardsCommandInUser($businessId, $data['user'], $data));
            }
            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function searchUser(string $email): array
    {
        try {
            $user = $this->ask(new UserQueryByUsername($email));
            return $user->data;
        } catch (\DomainException) {
            return [];
        }
    }

    private function ensureUserProfile(array $user): void
    {
        if (empty($user)) {
            return;
        }

        $ownerProfile = '8';
        if ($user['profileId'] !== $ownerProfile) {
            throw new \DomainException('No se le puede asignar tarjetas al usuario por su perfil', 400);
        }
    }
}
