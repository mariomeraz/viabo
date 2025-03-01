<?php declare(strict_types=1);


namespace Viabo\security\userLog\application\create;


use Viabo\security\userLog\domain\UserLog;
use Viabo\security\userLog\domain\UserLogRepository;

final readonly class UserLogCreator
{
    public function __construct(private UserLogRepository $repository)
    {
    }

    public function __invoke(string $userId , string $type , array $data): void
    {
        $log = UserLog::create($userId, $type, $data);
        $this->repository->save($log);
    }
}