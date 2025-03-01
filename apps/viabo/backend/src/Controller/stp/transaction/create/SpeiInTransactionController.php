<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\transaction\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\transaction\application\cretate_spei_in_transaction_by_stp\CreateSpeiInStpTransactionCommand;


final readonly class SpeiInTransactionController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $date = $request->query->getInt('date');
            $company = $request->query->getString('company');
            $stpAccountsDisable = $request->query->getBoolean('stp_accounts_disable');
            $this->dispatch(new CreateSpeiInStpTransactionCommand($date, $company, $stpAccountsDisable));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }


}