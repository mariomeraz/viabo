<?php declare(strict_types=1);


namespace Viabo\security\user\application\create_user_by_assign_card_cloud;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateUserCardCloudOwnerCommandHandler implements CommandHandler
{
    public function __construct(private CardCloudOwnerCreator $creator)
    {
    }

    public function __invoke(CreateUserCardCloudOwnerCommand $command): void
    {
        $this->creator->__invoke(
            $command->userId,
            '8',
            $command->user['name'],
            $command->user['lastname'],
            $command->user['phone'],
            $command->user['email'],
            $command->businessId
        );
    }
}