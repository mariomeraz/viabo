<?php declare(strict_types=1);


namespace Viabo\management\credential\application\create;


use Viabo\management\credential\domain\CardCredential;
use Viabo\management\credential\domain\CardCredentialEmail;
use Viabo\management\credential\domain\CardCredentialPassword;
use Viabo\management\credential\domain\CardCredentialRepository;
use Viabo\management\credential\domain\CardCredentialUserName;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CredentialCreatorOutside
{
    public function __construct(private CardCredentialRepository $repository , private EventBus $bus)
    {
    }

    public function __invoke(
        CardId                 $cardId ,
        CardCredentialEmail    $userEmail ,
        CardCredentialUserName $userName ,
        CardCredentialPassword $userPassword
    ): void
    {
        $credential = CardCredential::createOutside($cardId , $userEmail , $userName , $userPassword);
        $this->repository->save($credential);

        $this->bus->publish(...$credential->pullDomainEvents());
    }


}