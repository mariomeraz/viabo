<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\delete;


use Viabo\backoffice\documents\domain\DocumentRepository;
use Viabo\shared\domain\aggregate\AggregateRoot;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final class DocumentsDeleter extends AggregateRoot
{
    public function __construct(private readonly DocumentRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(string $companyId, array $uploadDocuments): void
    {
        foreach ($uploadDocuments as $documentName => $uploadDocument) {
            $filters = Filters::fromValues([
                ['field' => 'companyId', 'operator' => '=', 'value' => $companyId],
                ['field' => 'name.value', 'operator' => '=', 'value' => $documentName]
            ]);
            $document = $this->repository->searchCriteria(new Criteria($filters));

            if (empty($document)) {
                continue;
            }

            $document[0]->setEventDelete();
            $this->repository->delete($document[0]);

            $this->bus->publish(...$document[0]->pullDomainEvents());
        }
    }
}