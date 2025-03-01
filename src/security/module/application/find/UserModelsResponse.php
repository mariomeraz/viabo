<?php declare(strict_types=1);


namespace Viabo\security\module\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class UserModelsResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}