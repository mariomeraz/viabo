<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\terminalTransaction;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\commercePayCredentials\application\find\PayServiceCredentialsQuery;
use Viabo\management\commerceTerminal\application\find\TerminalsQuery;
use Viabo\management\terminalConsolidation\application\find\TerminalConciliationsQuery;
use Viabo\management\terminalTransaction\application\find\TerminalsTransactionsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class TerminalsTransactionFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $startDate = $request->query->getString('fromDate');
            $endDate = $request->query->getString('toDate');
            $terminalId = $request->query->getString('terminalId');
            $page = $request->query->getString('page');
            $pageSize = $request->query->getString('pageSize');
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $credentials = $this->ask(new PayServiceCredentialsQuery($company->data['id']));
            $terminals = $this->ask(new TerminalsQuery($company->data['id']));
            $conciliation = $this->searchConciliation($terminals->data, $terminalId);
            $transactions = $this->searchTransactions(
                $company->data,
                $credentials->data,
                $terminalId,
                $terminals->data,
                $conciliation,
                $startDate,
                $endDate,
                $page,
                $pageSize
            );

            return new JsonResponse($transactions);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function searchConciliation(array $terminals, string $terminalId): array
    {
        $conciliation = $this->ask(new TerminalConciliationsQuery($terminals, $terminalId));
        return $conciliation->data;
    }

    public function searchTransactions(
        array  $company,
        array  $credentials,
        string $terminalId,
        array  $terminals,
        array  $conciliation,
        string $startDate,
        string $endDate,
        string $page,
        string $pageSize
    ): array
    {
        if(empty($credentials)){
            return [];
        }

        $terminalsTransactions = $this->ask(new TerminalsTransactionsQuery(
            $company['id'],
            $credentials['apiKey'],
            $terminalId,
            $terminals,
            $conciliation,
            $startDate,
            $endDate,
            $page,
            $pageSize,
        ));
        return $terminalsTransactions->data;
    }
}
