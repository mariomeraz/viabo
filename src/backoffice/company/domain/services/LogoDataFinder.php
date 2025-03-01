<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\services;


use Viabo\shared\domain\uploadFile\UploadFileRepository;

final readonly class LogoDataFinder
{
    public function __construct(private UploadFileRepository $uploadFileRepository)
    {
    }

    public function __invoke(array $files): array
    {
        return array_map(function (object $file) {
            return $this->uploadFileRepository->data($file);
        } , $files);
    }

}