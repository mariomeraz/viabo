<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain\services;


use Viabo\management\receipt\domain\Invoice;
use Viabo\shared\domain\serializer\SerializerRepository;
use Viabo\shared\domain\uploadFile\UploadFileRepository;
use Viabo\shared\domain\Utils;

final readonly class InvoiceDataFinder
{
    public function __construct(
        private UploadFileRepository $uploadFileRepository ,
        private SerializerRepository $serializerRepository
    )
    {
    }

    public function __invoke(array $files)
    {
        $copyFiles = $files;
        $invoices = array_map(function (object $file) {
            $fileData = $this->uploadFileRepository->data($file);
            return $this->xmlData($file , $fileData);
        } , $copyFiles);
        $invoices = Utils::removeArrayNulls($invoices);

        return empty($invoices) ? [] : $invoices[0];
    }

    private function xmlData(object $file , array $fileData): array|null
    {
        if ($fileData['extension'] !== 'xml') {
            return null;
        }

        $directoryTemp = '/temp/files';
        $tempPath = "$directoryTemp/{$fileData['name']}";
        $this->uploadFileRepository->copy($file , $tempPath);
        $xml = $this->serializerRepository->deserializeXML($tempPath);
        $this->uploadFileRepository->remove($tempPath);
        $invoice = Invoice::fromXML($xml);

        return $invoice->toArray();
    }
}