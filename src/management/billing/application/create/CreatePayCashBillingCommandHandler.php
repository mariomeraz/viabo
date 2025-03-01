<?php declare(strict_types=1);


namespace Viabo\management\billing\application\create;


use Viabo\management\billing\domain\BillingData;
use Viabo\management\billing\domain\BillingReferencePayCash;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreatePayCashBillingCommandHandler implements CommandHandler
{
    public function __construct(private PayCashBillingCreator $creator)
    {
    }

    public function __invoke(CreatePayCashBillingCommand $command): void
    {
        $referencePayCash = BillingReferencePayCash::create($command->payment['Referencia']);
        $data = BillingData::create($command->payment);

        $this->creator->__invoke($referencePayCash, $data);
    }
}