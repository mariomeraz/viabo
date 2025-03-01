<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardSPEIKey;


use Viabo\shared\domain\bus\command\Command;

final readonly class SendCardSPEIKeyCommand implements Command
{
    public function __construct(public string $spei , public array $emails)
    {
    }
}