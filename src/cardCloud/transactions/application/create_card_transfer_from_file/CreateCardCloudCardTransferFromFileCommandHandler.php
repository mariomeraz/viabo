<?php declare(strict_types=1);


namespace Viabo\cardCloud\transactions\application\create_card_transfer_from_file;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCardCloudCardTransferFromFileCommandHandler implements CommandHandler
{
    public function __construct(private CardCloudCardTransferCreatorFromFile $creator)
    {
    }

    public function __invoke(CreateCardCloudCardTransferFromFileCommand $command): void
    {
        $this->creator->__invoke($command->businessId, $command->subAccount, $command->fileData);
    }
}