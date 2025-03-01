<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardsQueryHandlerByPaymentProcessor implements QueryHandler
{
    public function __construct(private CardsFinderByPaymentProcessor $finder)
    {
    }

    public function __invoke(CardsQueryByPaymentProcessor $query): Response
    {
        $commerceId = new CommerceId($query->commerceId);
        $paymentProcessorId = CardPaymentProcessorId::create($query->paymentProcessorId);

        return $this->finder->__invoke($commerceId, $paymentProcessorId);
    }
}