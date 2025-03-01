<?php declare(strict_types=1);

namespace Viabo\catalogs\threshold\application\find;

use Viabo\shared\domain\bus\query\Response;

final readonly class PayThresholdResponse implements Response
{

    public function __construct(public array $data)
    {
    }
}
