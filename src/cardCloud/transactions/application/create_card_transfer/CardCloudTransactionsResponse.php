<?php declare(strict_types=1);

namespace Viabo\cardCloud\transactions\application\create_card_transfer;

use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudTransactionsResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}
