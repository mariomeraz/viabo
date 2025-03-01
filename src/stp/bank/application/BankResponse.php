<?php declare(strict_types=1);


namespace Viabo\stp\bank\application;


use Viabo\shared\domain\bus\query\Response;

final readonly class BankResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}