<?php declare(strict_types=1);


namespace Viabo\security\code\domain;


use Viabo\security\code\domain\events\CodeCreatedDomainEvent;
use Viabo\security\shared\domain\user\UserId;
use Viabo\shared\domain\aggregate\AggregateRoot;

final  class Code extends AggregateRoot
{
    public function __construct(
        private readonly CodeId       $id,
        private readonly UserId       $userId,
        private readonly CodeValue    $value,
        private readonly CodeRegister $register,
    )
    {
    }

    public static function create(array $user): self
    {
        $code = new self(
            new CodeId(''),
            new UserId($user['id']),
            CodeValue::random(),
            CodeRegister::todayDate()
        );
        $user['code'] = $code->value->value();
        $code->record(new CodeCreatedDomainEvent($user['id'], $user));
        return $code;

    }

    public function isNotSame(string $code): bool
    {
        return $this->value->isNotSame($code);
    }

    public function isExpired(): bool
    {
        return $this->register->isExpired();
    }
}