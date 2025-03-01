<?php

namespace Viabo\Backend\Controller\backoffice\company\find;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_companies_by_companies_admin\CompaniesQueryByCompaniesAdmin;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CompaniesFinderController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $commerces = $this->ask(new CompaniesQueryByCompaniesAdmin(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));

            return new JsonResponse($commerces->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}