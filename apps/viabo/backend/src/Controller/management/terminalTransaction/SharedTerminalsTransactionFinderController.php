<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\terminalTransaction;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\commercePayCredentials\application\find\PayServiceCredentialsQuery;
use Viabo\management\commerceTerminal\application\find\TerminalsQuery;
use Viabo\management\terminalTransaction\application\find\SharedTerminalsTransactionsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class SharedTerminalsTransactionFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $startDate = $request->query->get('startDate');
            $endDate = $request->query->get('endDate');
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $credentials = $this->ask(new PayServiceCredentialsQuery($company->data['id']));
            $terminals = $this->ask(new TerminalsQuery($company->data['id']));
            $transactions = $this->ask(new SharedTerminalsTransactionsQuery(
                $company->data['id'],
                $credentials->data['apiKey'],
                $terminals->data,
                $startDate,
                $endDate,
            ));

            return new JsonResponse($transactions->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
