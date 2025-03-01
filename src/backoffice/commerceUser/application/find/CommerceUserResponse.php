<?php declare(strict_types=1);


namespace Viabo\backoffice\commerceUser\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceUserResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}