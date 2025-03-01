<?php declare(strict_types=1);


namespace Viabo\security\profile\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class ProfileLevelResponse implements Response
{
    public function __construct(public string $data)
    {
    }
}