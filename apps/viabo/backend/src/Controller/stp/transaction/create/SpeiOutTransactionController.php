<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\stp\transaction\create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\shared\infrastructure\symfony\ApiController;
use Viabo\stp\transaction\application\create_spei_out_transaction_by_stp\CreateSpeiOutTransactionCommandByStp;


final readonly class SpeiOutTransactionController extends ApiController
{

    public function __invoke(Request $request): Response
    {
        try {
            $company = $request->query->getString('company');
            $stpAccountDisable = $request->query->getBoolean('stp_accounts_disable');
            $this->dispatch(new CreateSpeiOutTransactionCommandByStp($company, $stpAccountDisable));

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }


}