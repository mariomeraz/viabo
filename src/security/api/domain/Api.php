<?php declare(strict_types=1);


namespace Viabo\security\api\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class Api extends AggregateRoot
{
    public function __construct(
        private ApiId     $id ,
        private ApiName   $name ,
        private ApiType   $type ,
        private ApiUrl    $url ,
        private ApiKey    $key ,
        private ApiActive $active
    )
    {
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url->value(),
            'key' => $this->key->valueDecrypt()
        ];
    }
}