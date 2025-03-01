<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class SupportReasonsQueryHandlerByApplicantProfile implements QueryHandler
{

    public function __construct(private SupportReasonFinderByCriteria $finder)
    {
    }

    public function __invoke(SupportReasonsQueryByApplicantProfile $query): Response
    {
        $filter = [
            ['field' => 'applicantProfileId.value' , 'operator' => '=' , 'value' => $query->userProfileId] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ];
        return $this->finder->__invoke($filter);
    }
}