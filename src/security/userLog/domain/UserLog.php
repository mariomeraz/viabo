<?php declare(strict_types=1);


namespace Viabo\security\userLog\domain;


final class UserLog
{
    public function __construct(
        private UserLogId          $id ,
        private UserLogAggregateId $aggregateId ,
        private UserLogType        $type ,
        private UserLogData        $data ,
        private UserLogOccurredOn  $occurredOn
    )
    {
    }

    public static function create(string $userId , string $type , array $data): static
    {
        return new static(
            UserLogId::random(),
            new UserLogAggregateId($userId),
            new UserLogType($type),
            UserLogData::create($data),
            UserLogOccurredOn::todayDate()
        );
    }
}