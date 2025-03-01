<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\backoffice\projection\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\cardCloud\subAccount\application\find_sub_account_by_company\SubAccountCardCloudServiceByCompanyQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class SubAccountFinderController extends ApiController
{

    public function __invoke(string $subAccountId, Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $company = $this->ask(new SubAccountCardCloudServiceByCompanyQuery(
                $tokenData['businessId'],
                $subAccountId
            ));
            return new JsonResponse($company->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
