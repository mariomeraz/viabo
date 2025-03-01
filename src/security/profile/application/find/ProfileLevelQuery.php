<?php declare(strict_types=1);


namespace Viabo\security\profile\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class ProfileLevelQuery implements Query
{
    public function __construct(public string $profileId)
    {
    }
}