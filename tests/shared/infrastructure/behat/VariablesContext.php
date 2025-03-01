<?php

namespace Viabo\Tests\shared\infrastructure\behat;

use Behat\Behat\Context\Context;

final class VariablesContext implements Context
{

    private string $token = '';

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

}
