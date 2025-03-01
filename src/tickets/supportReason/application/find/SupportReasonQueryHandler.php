<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class SupportReasonQueryHandler implements QueryHandler
{
    public function __construct(private SupportReasonFinder $finder)
    {
    }

    public function __invoke(SupportReasonQuery $query): Response
    {
        return $this->finder->__invoke($query->supportReasonId);
    }
}