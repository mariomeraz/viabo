<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\find;


use Viabo\tickets\supportReason\domain\services\SupportReasonFinder as SupportReasonFinderService;

final readonly class SupportReasonFinder
{
    public function __construct(private SupportReasonFinderService $finder)
    {
    }

    public function __invoke(string $supportReasonId): SupportReasonResponse
    {
        $supportReason = $this->finder->search($supportReasonId);
        return new SupportReasonResponse($supportReason->toArray());
    }
}