<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class DepositReferenceResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}