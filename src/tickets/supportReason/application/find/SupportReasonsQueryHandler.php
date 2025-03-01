<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class SupportReasonsQueryHandler implements QueryHandler
{
    public function __construct(private SupportReasonsFinder $finder)
    {
    }

    public function __invoke(SupportReasonsQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}