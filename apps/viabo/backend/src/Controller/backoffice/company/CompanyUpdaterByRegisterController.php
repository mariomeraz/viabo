<?php

namespace Viabo\Backend\Controller\backoffice\company;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\company\application\update_company_by_register\UpdateCompanyCommandByRegister;
use Viabo\shared\infrastructure\symfony\ApiController;


final readonly class CompanyUpdaterByRegisterController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $request = $request->toArray();
            $request = $this->formatData($request);
            $this->dispatch(new UpdateCompanyCommandByRegister(
                $request['commerceId'],
                $request['fiscalPersonType'],
                $request['fiscalName'],
                $request['tradeName'],
                $request['rfc'],
                $request['registerStep'],
                $request['services']
            ));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function formatData(array $request): array
    {
        $services = array_map(function (array $service) use ($request) {
            return array_merge($service, [
                'employees' => $request['employees'],
                'branchOffices' => $request['branchOffices'],
                'pointSaleTerminal' => $request['pointSaleTerminal'],
                'paymentApi' => $request['paymentApi'],
            ]);
        }, $request['services']);

        $request['services'] = $services;
        return $request;
    }
}