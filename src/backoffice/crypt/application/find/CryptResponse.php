<?php declare(strict_types=1);


namespace Viabo\backoffice\crypt\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class CryptResponse implements Response
{
    public function __construct(public string $data)
    {
    }
}