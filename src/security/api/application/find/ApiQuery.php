<?php declare(strict_types=1);


namespace Viabo\security\api\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class ApiQuery implements Query
{
    public function __construct(public string $apiName)
    {
    }
}