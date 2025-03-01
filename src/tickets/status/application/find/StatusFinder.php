<?php declare(strict_types=1);


namespace Viabo\tickets\status\application\find;


use Viabo\tickets\status\domain\exceptions\StatusNotExist;
use Viabo\tickets\status\domain\StatusRepository;

final readonly class StatusFinder
{
    public function __construct(private StatusRepository $repository)
    {
    }

    public function __invoke(string $statusId): StatusResponse
    {
        $status = $this->repository->search($statusId);

        if(empty($status)){
            throw new StatusNotExist();
        }

        return new StatusResponse($status->toArray());
    }
}