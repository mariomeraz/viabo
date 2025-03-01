<?php

namespace Viabo\Backend\Controller\backoffice\company\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\update\ToggleCompanyCommand;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CompanyToggleController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $companyId = $request->query->getString('company');
            $active = $request->query->getBoolean('active');

            $this->dispatch(new ToggleCompanyCommand($tokenData['id'], $companyId, $active));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}