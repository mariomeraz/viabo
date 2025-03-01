<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


final readonly class UserFinderRequest
{
    public function __construct(private string $userId)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}