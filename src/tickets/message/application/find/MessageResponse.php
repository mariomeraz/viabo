<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class MessageResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}