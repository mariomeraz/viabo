<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


final class PayCashData
{
    public function __construct(
        private string $url ,
        private string $key ,
        private string $instructionsUrl ,
        private string $instructionsFormatUrl ,
        private string $instructionsDownloadUrl
    )
    {
    }

    public static function create(array $data , array $instructions = []): static
    {
        $instructionsUrl = $instructions['url'] ?? '';
        return new static($data['url'] , $data['key'] , $instructionsUrl , '' , '');
    }

    public function setInstructionsUrls(string $senderId , string $payCashReferenceBase64Encode): void
    {
        $senderId = base64_encode(sha1($senderId));
        $senderId = "emisor=$senderId";
        $key = base64_encode(sha1($this->key));
        $key = "token={$key}";
        $payCashReference = "referencia=$payCashReferenceBase64Encode";
        $this->instructionsFormatUrl = "{$this->instructionsUrl}/formato.php?$senderId&$key&$payCashReference";
        $this->instructionsDownloadUrl = "{$this->instructionsUrl}/download.php?$senderId&$key&$payCashReference";
    }

    public function instructionsUrls(): array
    {
        return [
            'format' => $this->instructionsFormatUrl ,
            'download' => $this->instructionsDownloadUrl
        ];
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key ,
            'url' => $this->url ,
            'instructionsUrl' => $this->instructionsUrl
        ];
    }
}