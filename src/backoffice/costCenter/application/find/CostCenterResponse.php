<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class CostCenterResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}