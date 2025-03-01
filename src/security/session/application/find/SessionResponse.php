<?php declare(strict_types=1);


namespace Viabo\security\session\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class SessionResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}