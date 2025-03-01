<?php

namespace Viabo\Backend\Controller\backoffice\costCenter\find;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\costCenter\application\find\CostCentersQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CostCentersFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $costCenters = $this->ask(new CostCentersQuery($tokenData['businessId']));

            return new JsonResponse($costCenters->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}