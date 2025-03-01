<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyLogo extends StringValueObject
{
    private string $directoryPath;

    public static function empty(): static
    {
        return new static('');
    }

    public function update(array $fileData , string $commerceId): static
    {
        $logo = empty($this->value) ? self::empty() : new static($this->value);
        if (!empty($fileData)) {
            $logo->setDirectoryPath($commerceId);
            $logo->setPath($fileData);
        }
        return $logo;
    }

    public function allowedExtensions(): array
    {
        return ['png' , 'svg' , 'webp'];
    }

    private function setDirectoryPath(string $commerceId): void
    {
        $this->directoryPath = "/Business/Commerce_$commerceId/Logo";
    }

    private function setPath(array $fileData): void
    {
        $this->value = "/storage$this->directoryPath/Logo.{$fileData['logo']['extension']}";
    }

    public function directoryPath(): string
    {
        return $this->directoryPath;
    }

    public function data(): array
    {
        return [
            'directoryPath' => $this->directoryPath ,
            'allowedExtensions' => $this->allowedExtensions() ,
            'name' => 'Logo'
        ];
    }

}