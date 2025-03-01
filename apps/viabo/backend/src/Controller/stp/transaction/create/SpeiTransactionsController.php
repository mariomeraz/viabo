<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\transaction\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\stpAccount\application\create\UpdateStpAccountBalanceCommand;
use Viabo\stp\transaction\application\create_spei_out_transaction_by_stp\CreateSpeiOutTransactionCommandByStp;
use Viabo\stp\transaction\application\cretate_spei_in_transaction_by_stp\CreateSpeiInStpTransactionCommand;


final readonly class SpeiTransactionsController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $date = $request->query->getInt('date');
            $company = $request->query->getString('company');
            $stpAccountsDisable = $request->query->getBoolean('stp_accounts_disable');
            $this->dispatch(new CreateSpeiInStpTransactionCommand($date, $company, $stpAccountsDisable));
            $this->dispatch(new CreateSpeiOutTransactionCommandByStp($company, $stpAccountsDisable));
            $this->dispatch(new UpdateStpAccountBalanceCommand($company, $stpAccountsDisable));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

}