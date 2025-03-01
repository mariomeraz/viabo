<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\shared\domain\bus\query\Response;

final class TerminalsResponse implements Response
{
    public function __construct(public array $data) {
    }
}
