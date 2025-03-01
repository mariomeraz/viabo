<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\company\create;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\create_company_by_admin_stp\CreateCompanyCommandByAdminStp;
use Viabo\backoffice\company\application\delete\DeleteCompanyCommand;
use Viabo\backoffice\users\application\create_users_by_admin_stp\CreateCompanyUserCommand;
use Viabo\security\user\application\create_user_by_admin_stp\CreateUserCommandByAdminStp;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CompanyCreatorControllerByAdminStp extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $companyId = $this->generateUuid();
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $businessId = $tokenData['businessId'];
            $this->dispatch(new CreateCompanyCommandByAdminStp(
                $tokenData['id'],
                $businessId,
                $companyId,
                $data['fiscalName'],
                $data['commercialName'],
                $data['rfc'],
                $data['stpAccount'],
                $data['assignedUsers'],
                $data['costCenters'],
                $data['commissions']
            ));

            if ($data['isNewUser']) {
                $userId = $this->createAdminStpUser($data, $businessId);
                $this->dispatch(new CreateCompanyUserCommand([
                    'id' => $companyId,
                    'businessId' => $businessId,
                    'users' => [$userId]
                ]));
            }

            return new JsonResponse();
        } catch (\DomainException $exception) {
            $this->deleteCompany($companyId);
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function createAdminStpUser(array $data, string $businessId): string
    {
        $userId = $this->generateUuid();
        $adminStpProfileId = '7';
        $this->dispatch(new CreateUserCommandByAdminStp(
            $userId,
            $businessId,
            $adminStpProfileId,
            $data['userName'],
            $data['userLastName'],
            $data['userEmail'],
            $data['userPhone']
        ));
        return $userId;
    }

    private function deleteCompany(string $companyId): void
    {
        $this->dispatch(new DeleteCompanyCommand($companyId));
    }
}