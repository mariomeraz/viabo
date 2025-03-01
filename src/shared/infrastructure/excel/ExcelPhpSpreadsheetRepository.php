<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\excel;


use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Viabo\shared\domain\excel\ExcelRepository;

final class ExcelPhpSpreadsheetRepository implements ExcelRepository
{
    public function data(mixed $file): array
    {
        if (!$file instanceof UploadedFile){
            throw new \DomainException('No se subio ningun archivo de excel',400);
        }

        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $range = $worksheet->calculateWorksheetDataDimension();
        $data = $worksheet->rangeToArray($range);
        array_shift($data);
        return $data;
    }
}