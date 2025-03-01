<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class CredentialResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}