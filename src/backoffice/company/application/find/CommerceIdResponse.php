<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceIdResponse implements Response
{
    public function __construct(public string $data)
    {
    }
}