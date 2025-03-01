<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardOwnerId;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class PaymentProcessorsOfCommerceQueryHandler implements QueryHandler
{
    public function __construct(private PaymentProcessorsOfCommerceFinder $finder)
    {
    }

    public function __invoke(PaymentProcessorsOfCommerceQuery $query): Response
    {
        $commerceId = CardCommerceId::create($query->commerceId);
        $ownerId = CardOwnerId::create($query->userId);
        return $this->finder->__invoke($commerceId , $ownerId, $query->userProfileId );
    }
}