<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\find;


use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\tickets\supportReason\domain\SupportReason;
use Viabo\tickets\supportReason\domain\SupportReasonRepository;

final readonly class SupportReasonFinderByCriteria
{
    public function __construct(private SupportReasonRepository $repository)
    {
    }

    public function __invoke(array $filter): SupportReasonResponse
    {
        $filters = Filters::fromValues($filter);
        $supportReasons = $this->repository->searchCriteria(new Criteria($filters));

        return new SupportReasonResponse(array_map(function (SupportReason $supportReason) {
            return $supportReason->toArray();
        } , $supportReasons));

    }
}