<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ResetCardOwnerPasswordCommandHandler implements CommandHandler
{
    public function __construct(private UserPasswordResetter $resetter)
    {
    }

    public function __invoke(ResetCardOwnerPasswordCommand $command): void
    {
        $this->resetter->__invoke($command->userId);
    }
}