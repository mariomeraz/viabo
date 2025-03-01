<?php

namespace Viabo\Backend\Controller\security\module\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\backoffice\projection\application\find_company_services_by_user\CompanyServicesTypeIdQueryByUser;
use Viabo\security\module\application\find\UserModulesQuery;
use Viabo\security\user\application\find\UserPermissionQuery;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class UserModulesFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $servicesTypeId = $this->ask(new CompanyServicesTypeIdQueryByUser(
                $tokenData['id'],
                $tokenData['profileId'],
                $tokenData['businessId'],
            ));
            $permission = $this->ask(new UserPermissionQuery($tokenData['id']));
            $modules = $this->ask(new UserModulesQuery($permission->data, $servicesTypeId->data));

            return new JsonResponse($modules->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

}