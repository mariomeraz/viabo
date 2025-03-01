<?php declare(strict_types=1);

namespace Viabo\management\commercePayCredentials\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class PayServiceCredentialsQueryHandler implements QueryHandler
{
    public function __construct(private PayServiceCredentialsFinder $finder)
    {
    }

    public function __invoke(PayServiceCredentialsQuery $query): Response
    {
        return $this->finder->__invoke($query->companyId);
    }
}
