<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\backoffice\costCenter\update;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\costCenter\application\update\AddUserToCostCenterCommand;
use Viabo\backoffice\costCenter\application\update\UpdateCostCenterCommand;
use Viabo\security\user\application\create_user_by_admin_stp\CreateUserCommandByAdminStp;
use Viabo\security\user\application\find\ValidateUserNewCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CostCenterUpdaterController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $data = $request->toArray();

            $this->validateNewUser($data);
            $this->dispatch(new UpdateCostCenterCommand(
                $tokenData['id'],
                $data['id'],
                $data['name'],
                $data['assignedUsers']
            ));
            $this->addUserNewInCostCenter($data);

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function validateNewUser(array $data): void
    {
        if ($data['isNewUser']) {
            $this->dispatch(new ValidateUserNewCommand($data['userName'], $data['userEmail']));
        }
    }

    private function addUserNewInCostCenter(array $data): void
    {
        if ($data['isNewUser']) {
            $userId = $this->createCostCenterAdminUser($data);
            $this->dispatch(new AddUserToCostCenterCommand($data['id'], $userId));
        }
    }

    public function createCostCenterAdminUser(array $data): string
    {
        $userId = $this->generateUuid();
        $costCenterAdministratorProfileId = '6';
        $this->dispatch(new CreateUserCommandByAdminStp(
            $userId,
            $costCenterAdministratorProfileId,
            $data['userName'],
            $data['userLastName'],
            $data['userEmail'],
            $data['userPhone']
        ));
        return $userId;
    }

}