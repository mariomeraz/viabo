<?php declare(strict_types=1);


namespace Viabo\management\billing\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateBillingCommand implements Command
{
    public function __construct(public ?array $depositData)
    {
    }
}