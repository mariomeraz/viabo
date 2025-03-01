<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application;


use Viabo\shared\domain\bus\query\Response;

final readonly class CompanyProjectionResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}