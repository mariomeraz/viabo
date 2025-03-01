<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\create;


use Viabo\shared\domain\bus\event\EventBus;
use Viabo\tickets\supportReason\domain\services\SupportReasonCreationValidator;
use Viabo\tickets\supportReason\domain\SupportReason;
use Viabo\tickets\supportReason\domain\SupportReasonRepository;

final readonly class SupportReasonCreator
{
    public function __construct(
        private SupportReasonRepository        $repository ,
        private SupportReasonCreationValidator $supportReasonCreationValidator,
        private EventBus $bus
    )
    {
    }

    public function __invoke(
        string $userId ,
        string $reason ,
        string $description ,
        string $applicantProfileId ,
        string $assignedProfileId ,
        string $color
    ): void
    {
        $this->supportReasonCreationValidator->__invoke($reason , $applicantProfileId , $assignedProfileId);

        $supportReason = SupportReason::create(
            $userId ,
            $reason ,
            $description ,
            $applicantProfileId ,
            $assignedProfileId ,
            $color ,
        );

        $this->repository->save($supportReason);

        $this->bus->publish(...$supportReason->pullDomainEvents());
    }

}