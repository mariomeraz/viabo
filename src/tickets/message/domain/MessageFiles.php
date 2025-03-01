<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain;


use Viabo\shared\domain\Collection;
use Viabo\shared\domain\Utils;

final class MessageFiles extends Collection
{
    public static function fromValues(array $values): static
    {
        return new static(array_map(self::fileBuilder() , $values));
    }

    private static function fileBuilder(): callable
    {
        return fn(array $values): MessageFile => MessageFile::fromValue($values);
    }

    public function value(): array
    {
        return array_map(function (MessageFile $file) {
            return $file->toArray();
        } , $this->items());
    }

    public function elements(): array
    {
        return $this->items();
    }

    public function directoryPath(): string
    {
        $directoryPaths = array_map(function (MessageFile $file) {
            return $file->directoryPath();
        } , $this->items());
        $directoryPath = Utils::removeDuplicateElements($directoryPaths);
        return empty($directoryPath) ? '' : $directoryPath[0];
    }

    protected function type(): string
    {
        return MessageFile::class;
    }
}