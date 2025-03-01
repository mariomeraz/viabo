<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardSPEIKey;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class SendCardSPEIKeyCommandHandler implements CommandHandler
{
    public function __construct(private SendCardSPEI $send)
    {
    }

    public function __invoke(SendCardSPEIKeyCommand $command): void
    {
        $this->send->__invoke($command->spei , $command->emails);
    }
}