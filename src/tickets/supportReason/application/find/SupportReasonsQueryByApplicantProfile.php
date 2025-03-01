<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class SupportReasonsQueryByApplicantProfile implements Query
{
    public function __construct(public string $userProfileId)
    {
    }
}