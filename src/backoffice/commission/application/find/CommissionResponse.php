<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class CommissionResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}