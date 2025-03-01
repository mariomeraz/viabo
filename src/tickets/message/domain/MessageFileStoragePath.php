<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class MessageFileStoragePath extends StringValueObject
{
    public static function create(string $ticketId , string $file): static
    {
        return new static("/storage/tickets/$ticketId/$file");
    }

    public function directoryPath(): string
    {
        $value = str_replace("/storage" , "" , $this->value);
        return dirname($value);
    }

}