<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class MainCardIdQueryHandler implements QueryHandler
{
    public function __construct(private MainCardFinder $finder)
    {
    }

    public function __invoke(MainCardIdQuery $query): Response
    {
        $commerceId = CardCommerceId::create($query->commerceId);
        $paymentProcessorId = CardPaymentProcessorId::create($query->paymentProcessorId);

        return $this->finder->__invoke($commerceId, $paymentProcessorId);
    }
}