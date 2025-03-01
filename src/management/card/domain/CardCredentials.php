<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\shared\domain\card\CardClientKey;

final class CardCredentials
{
    public function __construct(
        private CardClientKey $clientKey ,
        private CardUser      $user ,
        private CardPassword  $password
    )
    {
    }

    public static function empty(): static
    {
        return new static(
            new CardClientKey('') ,
            new CardUser('') ,
            new CardPassword('')
        );
    }

    public static function create(CardClientKey $clientKey , CardUser $user , CardPassword $password): static
    {
        return new static($clientKey , $user , $password);
    }

    public function clientKey(): CardClientKey
    {
        return $this->clientKey;
    }

    public function user(): CardUser
    {
        return $this->user;
    }

    public function password(): CardPassword
    {
        return $this->password;
    }
}