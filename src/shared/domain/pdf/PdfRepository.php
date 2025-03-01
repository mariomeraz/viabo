<?php declare(strict_types=1);


namespace Viabo\shared\domain\pdf;


interface PdfRepository
{
    public function output(string $html, array $config = []): string;

    public function generateUrl(string $html, array $config = []): string;
}