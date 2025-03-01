<?php declare(strict_types=1);


namespace Viabo\Backend\Controller\management\cardOperation;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\management\cardOperation\application\transactions\ReverseCardTransactionCommand;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class ReverseCardTransactionsProcessorController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->dispatch(new ReverseCardTransactionCommand());

            return new JsonResponse();
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
