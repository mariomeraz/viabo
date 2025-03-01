<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application;


use Viabo\shared\domain\bus\query\Response;

final readonly class CompanyUserResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}
