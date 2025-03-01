<?php declare(strict_types=1);

namespace Viabo\catalogs\threshold\application\find;

use Viabo\catalogs\threshold\domain\ThresholdName;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class PayThresholdQueryHandler implements QueryHandler
{
    public function __construct(private FinderPayThreshold $finder)
    {
    }

    public function __invoke(PayThresholdQuery $query):Response
    {
        $name = new ThresholdName($query->name);

        return $this->finder->__invoke($name);
    }
}
