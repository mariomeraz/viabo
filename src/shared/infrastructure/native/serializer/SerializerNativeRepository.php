<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\native\serializer;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Viabo\shared\domain\serializer\SerializerRepository;

final class SerializerNativeRepository implements SerializerRepository
{
    private string $rootDir;

    public function __construct(ParameterBagInterface $params)
    {
        $this->rootDir = $params->get('kernel.project_dir') . '/public/storage';
    }

    public function deserializeXML(string $path): object
    {
        return simplexml_load_file($this->rootDir . $path);
    }
}