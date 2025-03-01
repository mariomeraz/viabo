<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\commerceTerminal;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\commerceTerminal\application\find\TerminalsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CommerceTerminalsFinderController extends ApiController
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
            $terminal = $this->ask(new TerminalsQuery($company->data['id']));

            return new JsonResponse($terminal->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
