<?php declare(strict_types=1);


namespace Viabo\shared\domain\serializer;


interface SerializerRepository
{
    public function deserializeXML(string $path): object;
}