<?php declare(strict_types=1);


namespace Viabo\security\user\application\create_user_by_assign_card_cloud;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateUserCardCloudOwnerCommand implements Command
{
    public function __construct(public string $businessId, public string $userId, public array $user)
    {
    }
}