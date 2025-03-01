<?php declare(strict_types=1);

namespace Viabo\shared\domain\excel;

interface ExcelRepository
{

    public function data(mixed $file): array;
}