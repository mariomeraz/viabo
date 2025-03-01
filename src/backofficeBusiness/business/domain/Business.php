<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\domain;


use Viabo\shared\domain\aggregate\AggregateRoot;

final class Business extends AggregateRoot
{
    public function __construct(
        private BusinessId           $id,
        private BusinessName         $name,
        private BusinessTemplateFile $templateFile,
        private BusinessDomain       $domain,
        private BusinessActive       $active
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'templateFile' => $this->templateFile->value(),
            'domain' => $this->domain->value(),
            'host' => $this->domain->host(),
            'active' => $this->active->value()
        ];
    }
}