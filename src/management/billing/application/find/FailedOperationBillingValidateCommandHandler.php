<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\management\billing\domain\BillingApiKey;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class FailedOperationBillingValidateCommandHandler implements CommandHandler
{
    public function __construct(private FailedOperationBillingValidator $validator)
    {
    }

    public function __invoke(FailedOperationBillingValidateCommand $command): void
    {
        $apiKey = BillingApiKey::create($command->apiKey);

        $this->validator->__invoke($apiKey);
    }
}