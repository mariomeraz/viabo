<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\backoffice\company\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\users\application\find_company_card_holders\CompanyCardHoldersQuery;
use Viabo\cardCloud\cards\application\find_card_details\CardCloudCardDetailsQuery;
use Viabo\cardCloud\users\application\find_users_by_business\CardCloudUsersQuery;
use Viabo\security\session\application\find\SessionLastQuery;
use Viabo\security\user\application\find\FindUserQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardHoldersFinderByCompanyController extends ApiController
{

    public function __invoke(Request $request):Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $businessId = $tokenData['businessId'];
            $companyId = $request->query->getString('companyId');
            $cardHolders = $this->ask(new CompanyCardHoldersQuery($companyId));
            $cardCloudUsers = $this->ask(new CardCloudUsersQuery($businessId));
            $users = $this->addCardData($cardCloudUsers->data, $businessId, $cardHolders->data);

            return new JsonResponse($users);
        } catch (\DomainException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode() ? : 400);
        }
    }

    public function addCardData(array $cardCloudUsers, string $businessId, array $cardHolders):array
    {
        return array_map(function ($user) use ($cardCloudUsers, $businessId) {
            $cardCloudUser = $this->filterUserWithCard($cardCloudUsers, $user);
            $user = $this->searchUserData($user['id']);
            unset($user['password'], $user['stpAccountId']);
            $user['cards'] = empty($cardCloudUser) ? [] : $this->searchCardDetails($businessId, $cardCloudUser);
            $user['lastSession'] = $this->getLastSessionUser($user['id']);

            return $user;
        }, $cardHolders);
    }

    private function filterUserWithCard(array $cardCloudUsers, array $user):array
    {
        return array_filter($cardCloudUsers, function ($card) use ($user) {
            return $card['ownerId'] === $user['id'];
        });
    }

    private function searchCardDetails(string $businessId, array $cardsOwners):array
    {
        return array_values(array_map(function ($cardOwner) use ($businessId) {
            $cardDetails = $this->ask(new CardCloudCardDetailsQuery(
                    $businessId,
                    $cardOwner['cardId'],
                    $cardOwner
            ));

            return $cardDetails->data;
        }, $cardsOwners));
    }

    private function searchUserData(string $userId):array
    {
        $user = $this->ask(new FindUserQuery($userId, ''));

        return $user->data;
    }

    private function getLastSessionUser(string $userId):string
    {
        $lastSession = $this->ask(new SessionLastQuery($userId));

        return $lastSession->data['loginDate'] ?? '';
    }
}
