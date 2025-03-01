<?php declare(strict_types=1);

namespace Viabo\management\commercePayCredentials\application\find;

use Viabo\shared\domain\bus\query\Response;

final readonly class PayServiceCredentialsResponse implements Response
{
    public function __construct (public array $data)
    {
    }
}
