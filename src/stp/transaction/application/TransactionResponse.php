<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application;


use Viabo\shared\domain\bus\query\Response;

final readonly class TransactionResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}