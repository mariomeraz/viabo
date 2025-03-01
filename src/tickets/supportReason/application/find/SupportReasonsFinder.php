<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\find;


use Viabo\tickets\supportReason\domain\SupportReason;
use Viabo\tickets\supportReason\domain\SupportReasonRepository;

final readonly class SupportReasonsFinder
{
    public function __construct(private SupportReasonRepository $repository)
    {
    }

    public function __invoke(): SupportReasonResponse
    {
        $supportReasons = $this->repository->searchAll();

        return new SupportReasonResponse(array_map(function (SupportReason $supportReason) {
            return $supportReason->toArray();
        } , $supportReasons));
    }
}