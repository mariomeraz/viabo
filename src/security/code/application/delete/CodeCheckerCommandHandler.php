<?php declare(strict_types=1);


namespace Viabo\security\code\application\delete;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CodeCheckerCommandHandler implements CommandHandler
{
    public function __construct(private CodeChecker $checker)
    {
    }

    public function __invoke(CodeCheckerCommand $command): void
    {
        $this->checker->__invoke($command->userId, $command->verificationCode);
    }
}