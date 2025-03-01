<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\application\find;


use Viabo\management\paymentProcessor\domain\PaymentProcessorId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FindPaymentProcessorQueryHandler implements QueryHandler
{
    public function __construct(private PaymentProcessorFinder $finder)
    {
    }

    public function __invoke(FindPaymentProcessorQuery $query): Response
    {
        $paymentProcessorId = new PaymentProcessorId($query->paymentProcessorId);

        return $this->finder->__invoke($paymentProcessorId);
    }
}