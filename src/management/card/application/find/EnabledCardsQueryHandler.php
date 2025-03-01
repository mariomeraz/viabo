<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardOwnerId;
use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class EnabledCardsQueryHandler implements QueryHandler
{
    public function __construct(private EnabledCardsFinder $finder)
    {
    }

    public function __invoke(EnabledCardsQuery $query): Response
    {
        $commerceId = new CardCommerceId($query->commerceId);
        $cardOwnerId = new CardOwnerId($query->userId);
        $paymentProcessorId = CardPaymentProcessorId::create($query->paymentProcessorId);

        return $this->finder->__invoke($commerceId , $cardOwnerId , $paymentProcessorId , $query->userProfileId);
    }

}