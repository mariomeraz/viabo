<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\shared\domain\bus\command\Command;

final readonly class FailedOperationBillingValidateCommand implements Command
{
    public function __construct(public ?string $apiKey)
    {
    }
}