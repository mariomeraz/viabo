<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class GoogleAuthenticatorQRResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}