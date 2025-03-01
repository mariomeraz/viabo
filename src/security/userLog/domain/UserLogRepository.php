<?php declare(strict_types=1);


namespace Viabo\security\userLog\domain;


interface UserLogRepository
{
    public function save(UserLog $log): void;
}