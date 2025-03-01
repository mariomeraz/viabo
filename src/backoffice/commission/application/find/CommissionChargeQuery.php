<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CommissionChargeQuery implements Query
{
    public function __construct(
        public string $commerceId ,
        public string $paymentProcessor ,
        public string $amount
    )
    {
    }
}