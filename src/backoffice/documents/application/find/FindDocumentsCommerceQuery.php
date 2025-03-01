<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class FindDocumentsCommerceQuery implements Query
{
    public function __construct(public string $commerceId)
    {
    }
}