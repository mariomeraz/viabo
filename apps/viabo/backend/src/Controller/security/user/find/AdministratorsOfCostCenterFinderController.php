<?php

namespace Viabo\Backend\Controller\security\user\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\find_admin_cost_centers\CostCenterAdminsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class AdministratorsOfCostCenterFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $admins = $this->ask(new CostCenterAdminsQuery($tokenData['businessId']));

            return new JsonResponse($admins->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

}