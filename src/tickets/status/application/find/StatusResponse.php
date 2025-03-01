<?php declare(strict_types=1);


namespace Viabo\tickets\status\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class StatusResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}