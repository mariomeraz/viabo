<?php declare(strict_types=1);


namespace Viabo\stp\movement\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class MovementsQuery implements Query
{
    public function __construct(public array $stpAccount)
    {
    }
}