<?php declare(strict_types=1);


namespace Viabo\security\code\application\create;


use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\application\find\FindUserQuery;
use Viabo\shared\domain\bus\command\CommandHandler;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class CreateCodeCommandHandler implements CommandHandler
{
    public function __construct(private CodeCreator $creator , private QueryBus $queryBus)
    {
    }

    public function __invoke(CreateCodeCommand $command): void
    {
        $userEmail = '';
        $user = $this->queryBus->ask(new FindUserQuery($command->userId, $userEmail));

        $this->creator->__invoke($user->data);
    }
}