<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\symfony\uploadFile;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Viabo\shared\domain\uploadFile\FileFormatNotAllowed;
use Viabo\shared\domain\uploadFile\IsNotFile;

final class UploadedFileSymfonyAdapter
{
    private string $rootDir;
    private string $fileName;
    private string $directory;
    private string $path;
    private string $originalFileName;

    public function __construct(ParameterBagInterface $params)
    {
        $this->rootDir = $params->get('kernel.project_dir') . '/public/storage';
        $this->fileName = '';
        $this->directory = '';
        $this->path = '';
    }

    public function upload(object $file , string $path , array $extensions = [] , string $name = ''): void
    {
        if (!($file instanceof UploadedFile)) {
            throw new IsNotFile();
        }

        if (!$file->isFile()) {
            throw new IsNotFile();
        }

        $fileExtension = $file->getClientOriginalExtension();
        if (!in_array($fileExtension , $extensions) && !empty($extensions)) {
            throw new FileFormatNotAllowed();
        }

        if (empty($name)) {
            $name = pathinfo($file->getClientOriginalName() , PATHINFO_FILENAME);
        }

        $directory = $this->rootDir . $path;
        $this->originalFileName = strtoupper($name);
        $fileName = "$this->originalFileName.$fileExtension";
        $this->path = "$path/$fileName";

        $file->move($directory , $fileName);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function fileName(): string
    {
        return $this->originalFileName;
    }

    public function removeFile(string $storePath): void
    {
        unlink($this->rootDir . $storePath);
    }
}