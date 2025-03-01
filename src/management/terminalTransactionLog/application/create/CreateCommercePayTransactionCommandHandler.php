<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\application\create;

use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransactionLog\domain\CommercePayTransactionTypeId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCommercePayTransactionCommandHandler implements CommandHandler
{
    public function __construct(private TerminalTransactionLogCreator $creator)
    {
    }

    public function __invoke(CreateCommercePayTransactionCommand $command): void
    {
        $commercePayId = CommercePayId::create($command->commercePayData['id']);
        $commercePayData = $command->commercePayData;
        $commercePayData['merchantId'] = $command->merchantId;
        $commercePayData['apiKey'] = $command->apiKey;

        $transactionPayType = "1";
        $transactionTypeId = new CommercePayTransactionTypeId($transactionPayType);

        $this->creator->__invoke(
            $commercePayId ,
            $transactionTypeId,
            $commercePayData ,
            $command->cardData
        );
    }


}
