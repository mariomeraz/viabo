<?php declare(strict_types=1);


namespace Viabo\management\credential\application\create;


use Viabo\management\credential\domain\CommerceCredentials;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCredentialCommandHandler implements CommandHandler
{
    public function __construct(private CredentialCreator $creator)
    {
    }

    public function __invoke(CreateCardCredentialCommand $command): void
    {
        $cardId = new CardId($command->cardId);
        $commerceCredentials = CommerceCredentials::create(
            $command->mainKey, $command->masterCardKey, $command->carnetKey
        );

        ($this->creator)($cardId, $commerceCredentials);
    }
}