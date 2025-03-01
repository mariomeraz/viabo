<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class MasterCardQueryHandlerByPaymentProcessor implements QueryHandler
{
    public function __construct(private MasterCardFinderByPaymentProcessor $finder)
    {
    }

    public function __invoke(MasterCardQueryByPaymentProcessor $query): Response
    {
        return $this->finder->__invoke($query->commerceId, $query->paymentProcessorId);
    }
}