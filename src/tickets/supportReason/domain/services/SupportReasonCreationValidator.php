<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain\services;


use Viabo\security\profile\application\find\ProfileLevelQuery;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\shared\domain\criteria\Filters;
use Viabo\tickets\supportReason\domain\exceptions\ApplicantProfileIdIsAdmin;
use Viabo\tickets\supportReason\domain\exceptions\ProfileLevelWrong;
use Viabo\tickets\supportReason\domain\exceptions\SupportReasonExist;

final readonly class SupportReasonCreationValidator
{

    public function __construct(private SupportReasonFinder $finder , private QueryBus $queryBus)
    {
    }

    public function __invoke(string $reason , string $applicantProfileId , string $assignedProfileId): void
    {
        $this->ensureSupportReasonName($reason);
        $this->ensureApplicantProfileIdIsNotAdmin($applicantProfileId);
        $this->ensureProfileLevel($applicantProfileId , $assignedProfileId);
    }

    private function ensureSupportReasonName(string $reason): void
    {
        $filters = Filters::fromValues([
            ['field' => 'name.value' , 'operator' => '=' , 'value' => $reason]
        ]);
        $supportReason = $this->finder->searchCriteria($filters);

        if(!empty($supportReason)){
            throw new SupportReasonExist();
        }
    }

    private function ensureApplicantProfileIdIsNotAdmin(string $applicantProfileId): void
    {
        $profilesIds = ['adminProfileId' => '2' , 'systemProfileId' => '1'];
        if (in_array($applicantProfileId , $profilesIds)) {
            throw new ApplicantProfileIdIsAdmin();
        }
    }

    private function ensureProfileLevel(string $applicantProfileId , string $assignedProfileId): void
    {
        $applicantProfileLevel = $this->queryBus->ask(new ProfileLevelQuery($applicantProfileId));
        $assignedProfileLevel = $this->queryBus->ask(new ProfileLevelQuery($assignedProfileId));

        if ($applicantProfileLevel <= $assignedProfileLevel) {
            throw new ProfileLevelWrong();
        }
    }
}