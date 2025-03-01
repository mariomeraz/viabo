<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateSupportReasonCommandHandler implements CommandHandler
{
    public function __construct(private SupportReasonCreator $creator)
    {
    }

    public function __invoke(CreateSupportReasonCommand $command): void
    {
        $this->creator->__invoke(
            $command->userId,
            $command->reason,
            $command->description,
            $command->applicantProfileId,
            $command->assignedProfileId,
            $command->color
        );
    }
}