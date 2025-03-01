<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\commerceTerminal;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\commercePayCredentials\application\find\PayServiceCredentialsQuery;
use Viabo\management\commerceTerminal\application\find\FindTerminalsCommercePayQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommerceTerminalsPayFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $companyData =  $company->data;
            $commercePayCredential = $this->ask(new PayServiceCredentialsQuery($companyData['id']));
            $commercePayCredentialData = $commercePayCredential->data;
            $terminals = $this->ask(new FindTerminalsCommercePayQuery(
                $commercePayCredentialData['merchantId'] ,
                $commercePayCredentialData['apiKey']
            ));

            return new JsonResponse($terminals->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
