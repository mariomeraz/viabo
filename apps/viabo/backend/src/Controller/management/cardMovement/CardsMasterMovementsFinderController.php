<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\management\cardMovement;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\backoffice\projection\application\find_company_by_user\CompanyQueryByUser;
use Viabo\management\card\application\find\MainCardsInformationQuery;
use Viabo\management\cardMovement\application\find\CardsMasterMovementsQuery;
use Viabo\management\cardOperation\application\find\CardsOperationsQuery;
use Viabo\management\commercePayCredentials\application\find\PayServiceCredentialsQuery;
use Viabo\management\commerceTerminal\application\find\TerminalsQuery;
use Viabo\management\terminalTransaction\application\find\TerminalsTransactionsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class CardsMasterMovementsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $tokenData = $this->decode($request->headers->get('Authorization'));
            $startDate = $request->query->getString('startDate');
            $endDate = $request->query->getString('endDate');
            $company = $this->ask(new CompanyQueryByUser(
                $tokenData['id'],
                $tokenData['businessId'],
                $tokenData['profileId']
            ));
            $cardsInformation = $this->ask(new MainCardsInformationQuery($company->data['id']));
            $operationData = $this->ask(new CardsOperationsQuery($cardsInformation->data, $startDate, $endDate));
            $companyPayCredential = $this->ask(new PayServiceCredentialsQuery($company->data['id']));
            $terminalsData = $this->ask(new TerminalsQuery($company->data['id']));
            $payTransaction = $this->searchPayTransactions(
                $company->data['id'],
                $companyPayCredential->data['apiKey'],
                $terminalsData->data,
                $startDate,
                $endDate
            );
            $movements = $this->ask(new CardsMasterMovementsQuery(
                $cardsInformation->data,
                $operationData->data,
                $payTransaction,
                $startDate,
                $endDate
            ));

            return new JsonResponse($this->opensslEncrypt($movements->data));
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function searchPayTransactions(
        string $companyId,
        string $payCredential,
        array  $terminalsData,
        string $startDate,
        string $endDate
    ): array
    {
        if (empty($terminalsData)) {
            return [];
        }

        $payTransaction = $this->ask(new TerminalsTransactionsQuery(
            $companyId,
            $payCredential,
            "",
            $terminalsData,
            [],
            $startDate,
            $endDate,
            "",
            ""
        ));

        return $payTransaction->data;
    }
}
