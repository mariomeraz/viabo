<?php declare(strict_types=1);


namespace Viabo\security\api\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class ApiResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}