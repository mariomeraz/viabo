<?php declare(strict_types=1);


namespace Viabo\backoffice\crypt\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CryptQueryHandler implements QueryHandler
{
    public function __construct(private CryptFinder $finder)
    {
    }

    public function __invoke(CryptQuery $query): Response
    {
        return $this->finder->__invoke($query->value, $query->encrypt);
    }
}