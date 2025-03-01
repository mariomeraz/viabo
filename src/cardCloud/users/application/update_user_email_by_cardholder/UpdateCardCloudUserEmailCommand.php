<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\update_user_email_by_cardholder;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateCardCloudUserEmailCommand implements Command
{
    public function __construct(public string $ownerId, public string $email)
    {
    }
}