<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\backoffice\projection\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\subAccount\application\find_sub_account_movements_by_company\SubAccountCardCloudServiceMovementsByCompanyQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class SubAccountMovementsFinderController extends ApiController
{

    public function __invoke(string $subAccountId, Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $fromDate = $request->query->get('fromDate');
            $toDate = $request->query->get('toDate');
            $company = $this->ask(new SubAccountCardCloudServiceMovementsByCompanyQuery(
                $tokenData['businessId'],
                $subAccountId,
                $fromDate,
                $toDate
            ));
            return new JsonResponse($company->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
