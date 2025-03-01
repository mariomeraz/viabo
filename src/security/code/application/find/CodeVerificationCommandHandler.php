<?php declare(strict_types=1);


namespace Viabo\security\code\application\find;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CodeVerificationCommandHandler implements CommandHandler
{
    public function __construct(private CodeValidator $validator)
    {
    }

    public function __invoke(CodeVerificationCommand $command): void
    {
        $this->validator->__invoke($command->userId, $command->code);
    }
}