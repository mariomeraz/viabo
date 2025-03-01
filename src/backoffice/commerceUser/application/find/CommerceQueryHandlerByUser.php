<?php declare(strict_types=1);


namespace Viabo\backoffice\commerceUser\application\find;


use Viabo\backoffice\commerceUser\domain\CommerceUserKey;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceQueryHandlerByUser implements QueryHandler
{
    public function __construct(private CommerceFinderByUser $finder)
    {
    }

    public function __invoke(CommerceQueryByUser $query): Response
    {
        $userId = CommerceUserKey::create($query->userId);

        return $this->finder->__invoke($userId);
    }
}