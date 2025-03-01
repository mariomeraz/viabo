<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\costCenter\create;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\costCenter\application\create\CreateCostCenterCommand;
use Viabo\backoffice\costCenter\application\delete\DeleteCostCenterCommand;
use Viabo\backoffice\costCenter\application\update\AddUserToCostCenterCommand;
use Viabo\security\user\application\create_user_by_admin_stp\CreateUserCommandByAdminStp;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CostCenterCreatorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $costCenterId = $this->generateUuid();
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();
            $businessId = $tokenData['businessId'];

            $this->dispatch(new CreateCostCenterCommand(
                $tokenData['id'],
                $businessId,
                $costCenterId,
                $data['name'],
                $data['assignedUsers']
            ));

            if ($data['isNewUser']) {
                $userId = $this->createCostCenterAdminUser($data, $businessId);
                $this->dispatch(new AddUserToCostCenterCommand($costCenterId, $userId));
            }

            return new JsonResponse();
        } catch (\DomainException $exception) {
            $this->deleteCostCenter($costCenterId);
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function createCostCenterAdminUser(array $data, string $businessId): string
    {
        $userId = $this->generateUuid();
        $costCenterAdministratorProfileId = '6';
        $this->dispatch(new CreateUserCommandByAdminStp(
            $userId,
            $businessId,
            $costCenterAdministratorProfileId,
            $data['userName'],
            $data['userLastName'],
            $data['userEmail'],
            $data['userPhone']
        ));
        return $userId;
    }

    private function deleteCostCenter(string $costCenterId): void
    {
        $this->dispatch(new DeleteCostCenterCommand($costCenterId));
    }
}