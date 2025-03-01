<?php declare(strict_types=1);

namespace Viabo\catalogs\threshold\application\find;

use Viabo\shared\domain\bus\query\Query;

final readonly class PayThresholdQuery implements Query
{
    public function __construct(public string $name)
    {
    }
}
