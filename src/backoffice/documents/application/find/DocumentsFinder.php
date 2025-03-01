<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\find;


use Viabo\backoffice\documents\domain\Document;
use Viabo\backoffice\documents\domain\DocumentRepository;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final class DocumentsFinder
{

    public function __construct(private DocumentRepository $repository)
    {
    }

    public function __invoke(CompanyId $commerceId): DocumentsResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId->value() ]
        ]);
        $documents = $this->repository->searchCriteria(new Criteria($filters));
        return new DocumentsResponse(array_map(function (Document $document){
            return $document->toArray();
        }, $documents));
    }


}