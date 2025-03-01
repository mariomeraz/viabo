<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\stpAccount\update;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\stpAccount\application\create\UpdateStpAccountBalanceCommand;


final readonly class UpdateStpAccountBalanceController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $company = $request->query->getString('company');
            $stpAccountsDisable = $request->query->getBoolean('stp_accounts_disable');
            $this->dispatch(new UpdateStpAccountBalanceCommand($company, $stpAccountsDisable));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }


}