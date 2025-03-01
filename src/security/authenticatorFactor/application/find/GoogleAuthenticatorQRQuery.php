<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class GoogleAuthenticatorQRQuery implements Query
{
    public function __construct(public string $userName)
    {
    }
}