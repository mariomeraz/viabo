<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\create_sub_account;

use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudSubAccountResponse implements Response
{

    public function __construct(public array $data)
    {
    }
}
