<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateInformalCommerceCommand implements Command
{
    public function __construct(public string $tradeName)
    {
    }
}