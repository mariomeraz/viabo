<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\backoffice\projection\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_admin_company_users\AdminCompanyUsersByBusinessQuery;
use Viabo\security\session\application\find\SessionLastQuery;
use Viabo\security\user\application\find_admin_users_company\AdminUsersCompanyQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class AdminCompanyUsersFinderController extends ApiController
{

    public function __invoke(Request $request):Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $businessId = $tokenData['businessId'];
            $usersByCompanies = $this->ask(new AdminCompanyUsersByBusinessQuery($businessId));
            $adminCompanyUsers = $this->ask(new AdminUsersCompanyQuery($businessId));
            $users = $this->addUserData($adminCompanyUsers->data, $usersByCompanies->data);

            return new JsonResponse($users);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
    private function addUserData(array $adminCompanyUsers, array $usersByCompanies):array
    {
        return array_map(function ($adminCompanyUser) use ($usersByCompanies) {
            $usersByCompany = $this->filterUsersByCompany($usersByCompanies, $adminCompanyUser);
            $adminCompanyUser['companies'] = $this->reduceCompanyByUsers($usersByCompany);
            $adminCompanyUser['lastSession'] = $this->getLastSessionUser($adminCompanyUser['id']);

            return $adminCompanyUser;
        }, $adminCompanyUsers);
    }

    private function filterUsersByCompany(array $usersByCompanies, array $adminCompanyUser):array
    {
        return array_filter($usersByCompanies, function ($user) use ($adminCompanyUser) {
            return $user['id'] === $adminCompanyUser['id'];
        });
    }

    private function reduceCompanyByUsers(array $usersByCompany):array
    {
        return array_reduce($usersByCompany, function ($carry, $user) {
            return array_merge($carry, $user['companies']);
        }, []);
    }

    private function getLastSessionUser(string $userId):string
    {
        $lastSession = $this->ask(new SessionLastQuery($userId));
        return $lastSession->data['loginDate'] ?? '';
    }
}
