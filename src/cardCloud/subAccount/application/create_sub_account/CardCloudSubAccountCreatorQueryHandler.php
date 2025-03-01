<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\create_sub_account;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudSubAccountCreatorQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudSubAccountCreator $creator)
    {
    }

    public function __invoke(CardCloudSubAccountCreatorQuery $query): Response
    {
        return $this->creator->__invoke($query->businessId, $query->companyId, $query->rfc);
    }
}
