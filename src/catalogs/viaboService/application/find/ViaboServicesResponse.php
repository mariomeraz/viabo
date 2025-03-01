<?php declare(strict_types=1);


namespace Viabo\catalogs\viaboService\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class ViaboServicesResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}