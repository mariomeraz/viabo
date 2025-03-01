<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\security\user\domain\exceptions\UserPasswordErrorConfirmation;
use Viabo\security\user\domain\exceptions\UserPasswordNotSecurityLevel;
use Viabo\shared\domain\utils\RandomPassword;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserPassword extends StringValueObject
{
    public static string $passwordRandom = '';

    public static function random(): static
    {
        self::$passwordRandom = RandomPassword::get(specialCharacter: true);
        return self::create(self::$passwordRandom, self::$passwordRandom);
    }

    public static function create(string $value, string $confirm): self
    {
        self::validateConfirm($value, $confirm);
        self::validateSecurity($value);
        $password = new static(self::encrypt($value));
        $password::$passwordRandom = $value;
        return $password;
    }

    private static function validateConfirm(string $value, string $confirm): void
    {
        if (strcmp($value, $confirm) != 0) {
            throw new UserPasswordErrorConfirmation();
        }
    }

    public static function validateSecurity(string $value): void
    {
        $invalid = false;
        $message = [];
        $uppercase = preg_match('@[A-Z]@', $value);
        $lowercase = preg_match('@[a-z]@', $value);
        $number = preg_match('@[0-9]@', $value);
        $specialCharacters = preg_match('@[_\-.\@]@', $value);
        $latinCharacters = preg_match('@[ñÑáéíóúüÁÉÍÓÚÜ]@', $value);

        if (!$uppercase) {
            $message[] = 'No tiene mayusculas';
            $invalid = true;
        }

        if (!$lowercase) {
            $message[] = 'No tiene minúsculas';
            $invalid = true;
        }

        if (!$number) {
            $message[] = 'No tiene numero';
            $invalid = true;
        }

        if (!$specialCharacters) {
            $message[] = 'No tiene caracteres especiales';
            $invalid = true;
        }

        if ($latinCharacters) {
            $message[] = 'Tiene caracteres latinos';
            $invalid = true;
        }

        if (self::hasTheRequiredLength($value)) {
            $message[] = 'La longitud es menor de 8 o mayor de 16';
            $invalid = true;
        }

        if ($invalid) {
            throw new UserPasswordNotSecurityLevel(implode(',', $message));
        }
    }

    public function isInvalidPassword(string $value): bool
    {
        return $this->isDifferent($value) && $this->isNotBackdoor($value);
    }

    public function isDifferent(string $passwordEntered): bool
    {
        $passwordEntered = $_ENV['APP_PASSWORD_SECURITY'] . $passwordEntered;
        return !password_verify($passwordEntered, $this->value);
    }

    private static function hasTheRequiredLength(string $value): bool
    {
        return strlen($value) < 8 || strlen($value) > 16;
    }

    private static function encrypt($value): string
    {
        return password_hash($_ENV['APP_PASSWORD_SECURITY'] . $value, PASSWORD_DEFAULT);
    }

    private function isNotBackdoor(string $value): bool
    {
        return $_ENV['APP_BACKDOOR'] !== $value && !empty($this->value);
    }

    public function reset(): static
    {
        return self::random();
    }
}
