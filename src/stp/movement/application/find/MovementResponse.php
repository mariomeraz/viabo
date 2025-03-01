<?php declare(strict_types=1);


namespace Viabo\stp\movement\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class MovementResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}