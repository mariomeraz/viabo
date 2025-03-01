<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain\services;


use Viabo\backoffice\credential\domain\Credential;
use Viabo\backoffice\credential\domain\CredentialRepository;
use Viabo\backoffice\credential\domain\exceptions\CredentialExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CredentialValidator
{
    public function __construct(private CredentialRepository $repository)
    {
    }

    public function validateNotExist(Credential $credential): void
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $credential->commerce()->value() ]
        ]);

        $credential = $this->repository->searchCriteria(new Criteria($filters));

        if(!empty($credential)){
            throw new CredentialExist();
        }
    }
}