<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class EnabledCardsQuery implements Query
{
    public function __construct(
        public string  $commerceId ,
        public string  $userId ,
        public string  $userProfileId ,
        public ?string $paymentProcessorId
    )
    {
    }
}