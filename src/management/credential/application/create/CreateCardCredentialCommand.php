<?php declare(strict_types=1);


namespace Viabo\management\credential\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCardCredentialCommand implements Command
{
    public function __construct(
        public string $cardId ,
        public string $mainKey ,
        public string $masterCardKey ,
        public string $carnetKey
    )
    {
    }
}