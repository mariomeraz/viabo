<?php declare(strict_types=1);


namespace Viabo\shared\domain\service\find_busines_template_file;


use Viabo\backofficeBusiness\business\application\find_business\BusinessQuery;
use Viabo\shared\domain\bus\query\QueryBus;

final class BusinessTemplateFileFinder
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(string $businessId): string
    {
        $business = $this->queryBus->ask(new BusinessQuery($businessId));
        return $business->data['templateFile'];
    }
}