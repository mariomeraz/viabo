<?php declare(strict_types=1);


namespace Viabo\backoffice\crypt\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class CryptQuery implements Query
{
    public function __construct(public string $value , public bool $encrypt)
    {
    }
}