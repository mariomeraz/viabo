<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use SimpleXMLElement;

final class Invoice
{
    public function __construct(
        private string $version ,
        private string $series ,
        private string $folio ,
        private string $total ,
        private string $issuerRFC ,
        private string $issuerName ,
        private string $recipientRFC ,
        private string $recipientName ,
        private string $uuid ,
        private string $date
    )
    {
    }

    public static function fromXML(object $xml): static
    {
        if (!$xml instanceof SimpleXMLElement) {
            return self::empty();
        }
        $namespaces = $xml->getNamespaces(true);
        $xml->registerXPathNamespace('c', $namespaces['cfdi']);
        $xml->registerXPathNamespace('t', $namespaces['tfd']);

        $receiptData = self::receiptData($xml);
        $issuerData = self::issuerData($xml);
        $recipientData = self::recipientData($xml);
        $cdfiData = self::cdfiData($xml);
        return new static(
            $receiptData['version'] ,
            $receiptData['series'] ,
            $receiptData['folio'] ,
            $receiptData['total'] ,
            $issuerData['rfc'] ,
            $issuerData['name'] ,
            $recipientData['rfc'] ,
            $recipientData['name'] ,
            $cdfiData['uuid'] ,
            $receiptData['date']
        );
    }

    public static function empty(): static
    {
        return new static('' , '' , '' , '' , '', '', '', '', '', '');
    }

    private static function receiptData(SimpleXMLElement $xml): array
    {
        $data = [];
        foreach ($xml->xpath('//cfdi:Comprobante') as $attributes) {
            $data = [
                'version' => "{$attributes['Version']}" ,
                'series' => "{$attributes['Serie']}" ,
                'folio' => "{$attributes['Folio']}" ,
                'total' => "{$attributes['Total']}" ,
                'date' => "{$attributes['Fecha']}"
            ];
        }
        return $data;
    }

    private static function issuerData(SimpleXMLElement $xml): array
    {
        $data = [];
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $attributes) {
            $data = [
                'rfc' => "{$attributes['Rfc']}" ,
                'name' => "{$attributes['Nombre']}"
            ];
        }
        return $data;
    }

    private static function recipientData(SimpleXMLElement $xml): array
    {
        $data = [];
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $attributes) {
            $data = [
                'rfc' => "{$attributes['Rfc']}" ,
                'name' => "{$attributes['Nombre']}"
            ];
        }
        return $data;
    }

    private static function cdfiData(SimpleXMLElement $xml)
    {
        $data = [];
        foreach ($xml->xpath('//t:TimbreFiscalDigital') as $attributes) {
            $data = [
                'uuid' => "{$attributes['UUID']}" ,
            ];
        }
        return $data;
    }

    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'series' => $this->series,
            'folio' => $this->folio,
            'total' => $this->total,
            'issuerRFC' => $this->issuerRFC,
            'issuerName' => $this->issuerName,
            'recipientRFC' => $this->recipientRFC,
            'recipientName' => $this->recipientName,
            'uuid' => $this->uuid,
            'date' => $this->date
        ];
    }
}