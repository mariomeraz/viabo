<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class StpAccountResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}