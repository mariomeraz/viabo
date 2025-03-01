<?php declare(strict_types=1);


namespace Viabo\backoffice\fee\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class FeeResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}