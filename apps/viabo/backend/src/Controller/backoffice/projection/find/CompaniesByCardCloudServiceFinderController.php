<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\backoffice\projection\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_companies_with_service_card_cloud_by_admin\CompaniesWithCardCloudServiceByAdminQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CompaniesByCardCloudServiceFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $commerces = $this->ask(new CompaniesWithCardCloudServiceByAdminQuery(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            return new JsonResponse($commerces->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
