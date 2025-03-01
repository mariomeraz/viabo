<?php


namespace Viabo\shared\domain\email;


interface EmailRepository
{
    public function send(Email $email): void;
}