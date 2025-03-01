<?php declare(strict_types=1);


namespace Viabo\cardCloud\transactions\application\create_card_transfer_from_file;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCardCloudCardTransferFromFileCommand implements Command
{
    public function __construct(
        public string $businessId,
        public string $subAccount,
        public array  $fileData
    )
    {
    }
}