<?php declare(strict_types=1);


namespace Viabo\security\code\application\delete;


use Viabo\security\code\domain\CodeRepository;
use Viabo\security\code\domain\services\CodeFinder;

final readonly class CodeDeleter
{
    public function __construct(private CodeRepository $repository , private CodeFinder $finder)
    {
    }

    public function __invoke(string $userId , string $code): void
    {
        $code = $this->finder->__invoke($userId , $code);
        $this->repository->delete($code);
    }
}