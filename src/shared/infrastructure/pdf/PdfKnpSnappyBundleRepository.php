<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\pdf;


use Knp\Snappy\Pdf;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Viabo\shared\domain\pdf\PdfRepository;
use Viabo\shared\domain\utils\URL;

final readonly class PdfKnpSnappyBundleRepository implements PdfRepository
{
    private string $rootDir;

    public function __construct(
        ParameterBagInterface         $params,
        private Pdf                   $pdf,
    )
    {
        $this->rootDir = $params->get('kernel.project_dir') . '/public/storage';
    }

    public function output(string $html, array $config = []): string
    {
        return $this->pdf->getOutputFromHtml($html, $config);
    }

    public function generateUrl(string $html, array $config = []): string
    {
        $filePath = "$this->rootDir/temp/pdf/temp_transaction_stp.pdf";
        $this->pdf->generateFromHtml($html, $filePath, $config, true);
        return URL::get().'/storage/temp/pdf/temp_transaction_stp.pdf';
    }
}