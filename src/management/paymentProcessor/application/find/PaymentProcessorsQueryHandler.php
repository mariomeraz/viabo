<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class PaymentProcessorsQueryHandler implements QueryHandler
{
    public function __construct(private PaymentProcessorsFinder $finder)
    {
    }

    public function __invoke(PaymentProcessorsQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}