<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateSupportReasonCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $reason ,
        public string $description ,
        public string $applicantProfileId ,
        public string $assignedProfileId ,
        public string $color
    )
    {
    }
}