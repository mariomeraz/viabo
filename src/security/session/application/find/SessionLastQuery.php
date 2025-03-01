<?php declare(strict_types=1);


namespace Viabo\security\session\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class SessionLastQuery implements Query
{
    public function __construct(public string $userId)
    {
    }
}