<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\create;


use Viabo\shared\domain\bus\query\Response;

final readonly class FundingOrderResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}