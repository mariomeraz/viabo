<?php

namespace Viabo\Backend\Controller\backoffice\company\find;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company\CompanyQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CompanyFinderController extends ApiController
{

    public function __invoke(string $company, Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $company = $this->ask(new CompanyQuery($company));

            return new JsonResponse($company->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}