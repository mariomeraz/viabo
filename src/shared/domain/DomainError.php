<?php

namespace Viabo\shared\domain;

use DomainException;

abstract class DomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage(), $this->errorCode());
    }

    abstract public function errorCode(): int;

    abstract public function errorMessage(): string;

}