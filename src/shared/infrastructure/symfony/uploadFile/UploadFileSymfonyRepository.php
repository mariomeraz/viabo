<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\symfony\uploadFile;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Viabo\shared\domain\uploadFile\FileFormatNotAllowed;
use Viabo\shared\domain\uploadFile\IsNotFile;
use Viabo\shared\domain\uploadFile\UploadFileRepository;

final class UploadFileSymfonyRepository implements UploadFileRepository
{
    private string $rootDir;
    private string $fileName;
    private string $extension;
    private string $directory;
    private string $path;
    private string $originalName;
    private string $mimeType;

    public function __construct(ParameterBagInterface $params , private Filesystem $filesystem)
    {
        $this->rootDir = $params->get('kernel.project_dir') . '/public/storage';
        $this->fileName = '';
        $this->extension = '';
        $this->directory = '';
        $this->path = '';
        $this->mimeType = '';
    }

    public function upload(object $file , string $path , array $extensions = [] , string $name = ''): void
    {
        $this->ensureItIsFile($file);
        $this->setExtension($file);
        $this->ensureExtensionType($extensions);
        $this->setOriginalName($file , $name);
        $this->setPath($path);
        $this->setDirectory();
        $file->move($this->directory , $this->originalName);
    }

    public function copy(object $file , string $directoryTemp): void
    {
        $this->ensureItIsFile($file);
        $originalPath = $file->getRealPath();
        $this->filesystem->copy($originalPath , $this->rootDir . $directoryTemp);
    }

    public function data(object $file): array
    {
        $this->ensureItIsFile($file);
        $this->setExtension($file);
        $this->setOriginalName($file);
        $this->setMimeType($file);

        return [
            'name' => $this->originalName ,
            'extension' => $this->extension ,
            'mimeType' => $this->mimeType
        ];
    }

    public function remove(string $storePath): void
    {
        unlink($this->rootDir . $storePath);
    }

    public function removeDirectory(string $directoryPath): void
    {
        $path = $this->rootDir . $directoryPath;
        if (!file_exists($path)) {
            return;
        }

        foreach (scandir($path) as $file) {
            if (!in_array($file , ['.' , '..'])) {
                $this->remove("$directoryPath/$file");
            }
        }
        rmdir($path);
    }

    private function ensureItIsFile(object $file): void
    {
        if (!($file instanceof UploadedFile)) {
            throw new IsNotFile();
        }

        if (!$file->isFile()) {
            throw new IsNotFile();
        }
    }

    private function ensureExtensionType(array $extensions): void
    {
        if (!in_array($this->extension , $extensions) && !empty($extensions)) {
            throw new FileFormatNotAllowed();
        }
    }

    private function setOriginalName(object $file , string $name = ''): void
    {
        $name = empty($name) ? pathinfo($file->getClientOriginalName() , PATHINFO_FILENAME) : $name;
        $this->fileName = $name;
        $this->originalName = "$name.$this->extension";
    }

    private function setPath(string $path): void
    {
        $this->path = $path;
    }

    private function setDirectory(): void
    {
        $this->directory = $this->rootDir . $this->path;
    }

    private function setExtension(object $file): void
    {
        $this->extension = $file->getClientOriginalExtension();
    }

    private function setMimeType(object $file): void
    {
        $this->mimeType = $file->getMimeType();
    }
}