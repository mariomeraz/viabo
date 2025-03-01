<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\cardCloud\users\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\users\application\assign_user_in_company\AssignUserCommandInCompany;
use Viabo\cardCloud\users\application\assign_cards_in_user\AssignCardsCommandInUser;
use Viabo\security\user\application\create_user_by_assign_card_cloud\CreateUserCardCloudOwnerCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardCloudCardsAssignUserController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $businessId = $tokenData['businessId'];
            $data = $request->toArray();

            if ($data['isNewUser'] && !empty($data['cards']) && !empty($data['companyId'])) {
                $userId = $this->generateUuid();
                $data['user'] = $userId;
                $this->dispatch(new CreateUserCardCloudOwnerCommand($businessId, $userId, $data['newUser']));
                $this->dispatch(new AssignUserCommandInCompany($businessId, $data['companyId'], $userId));
            }

            $this->dispatch(new AssignCardsCommandInUser($businessId, $tokenData['id'], $data));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
