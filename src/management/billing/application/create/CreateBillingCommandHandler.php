<?php declare(strict_types=1);


namespace Viabo\management\billing\application\create;


use Viabo\management\billing\domain\BillingAmount;
use Viabo\management\billing\domain\BillingApiKey;
use Viabo\management\billing\domain\BillingCardNumber;
use Viabo\management\billing\domain\BillingData;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateBillingCommandHandler implements CommandHandler
{
    public function __construct(private BillingCreator $creator)
    {
    }

    public function __invoke(CreateBillingCommand $command): void
    {
        $data = BillingData::create($command->depositData);
        $apiKey = BillingApiKey::create($command->depositData['key'] ?? null);
        $cardNumber = BillingCardNumber::create($command->depositData['referencia'] ?? null);
        $amount = BillingAmount::create($command->depositData['monto'] ?? null);

        $this->creator->__invoke($apiKey , $cardNumber , $amount , $data);
    }
}