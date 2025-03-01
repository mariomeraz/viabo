<?php

namespace Viabo\Backend\Controller\security\user\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\security\user\application\find_companies_admins_by_business\AdministratorsOfCompaniesQuery;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class AdministratorsOfCompaniesFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $administrators = $this->ask(new AdministratorsOfCompaniesQuery($tokenData['businessId']));

            return new JsonResponse($administrators->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

}