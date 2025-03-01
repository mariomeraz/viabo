<?php declare(strict_types=1);


namespace Viabo\security\code\application\find;


use Viabo\security\code\domain\exceptions\CodeExpired;
use Viabo\security\code\domain\exceptions\WrongCode;
use Viabo\security\code\domain\services\CodeFinder;

final readonly class CodeValidator
{
    public function __construct(private CodeFinder $finder)
    {
    }

    public function __invoke(string $userId , string $verificationCode): void
    {
        $code = $this->finder->__invoke($userId , $verificationCode);

        if ($code->isNotSame($verificationCode)) {
            throw new WrongCode();
        }

        if ($code->isExpired()) {
            throw new CodeExpired();
        }

    }
}