<?php declare(strict_types=1);


namespace Viabo\security\api\domain;


use Viabo\security\api\domain\exceptions\APITokenEmpty;
use Viabo\shared\domain\utils\Crypt;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class ApiKey extends StringValueObject
{
    public static function create(string $value): self
    {
        $value = self::clean($value);
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new APITokenEmpty();
        }
    }

    private static function clean(?string $token): ?string
    {
        if ($token && str_starts_with($token , 'Bearer ')) {
            $token = substr($token , 7);
        }
        return $token;
    }

    public function valueDecrypt(): string
    {
        return Crypt::decrypt($this->value);
    }
}