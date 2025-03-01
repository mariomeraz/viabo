<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ReceiptFiles extends StringValueObject
{
    private array $filesOrigin;
    private string $directoryPath;
    private array $filesData;

    public static function fromOrigin(array $filesData , array $filesOrigin , string $receiptId): static
    {
        $files = new static('');
        $files->setFilesData($filesData);
        $files->setFilesOrigin($filesOrigin);
        $files->setDirectoryPath($receiptId);
        $files->setPaths($filesData);
        return $files;
    }

    public function hasTheNecessaryFilesForAnInvoice(): bool
    {
        $extensions = $this->extensions();
        return in_array('pdf' , $extensions) && in_array('xml' , $extensions);
    }

    public function hasFile(): bool
    {
        $extensions = $this->extensions();
        return (bool)preg_match("/^(jpg|png|gif|pdf)$/i" , implode(',' , $extensions));
    }

    private function setFilesOrigin(array $value): void
    {
        $this->filesOrigin = $value;
    }

    private function setDirectoryPath(string $receiptId): void
    {
        $this->directoryPath = "/viaboCard/receipt/$receiptId";
    }

    private function setFilesData(array $filesData): void
    {
        $this->filesData = $filesData;
    }

    private function extensions(): array
    {
        return array_map(function (array $value) {
            return strtolower($value['extension']);
        } , $this->filesData);
    }

    public function filesOriginal(): array
    {
        return $this->filesOrigin;
    }

    public function directoryPath(): string
    {
        return $this->directoryPath;
    }

    public function allowedExtensions(): array
    {
        return ['xml' , 'pdf' , 'img' , 'jpg' , 'png' , 'gif'];
    }

    private function setPaths(array $filesData): void
    {
        $paths = array_map(function (array $fileData) {
            return "/storage$this->directoryPath/{$fileData['name']}";
        } , $filesData);
        $this->value = implode(',' , $paths);
    }

    public function toArray(): array
    {
        return explode(',' , $this->value);
    }

}