<?php declare(strict_types=1);

namespace Viabo\shared\domain\uploadFile;

interface UploadFileRepository
{
    public function upload(object $file , string $path , array $extensions = [] , string $name = ''): void;

    public function copy(object $file , string $directoryTemp): void;

    public function data(object $file): array;

    public function remove(string $storePath): void;

    public function removeDirectory(string $directoryPath): void;

}