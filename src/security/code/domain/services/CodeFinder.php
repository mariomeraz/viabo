<?php declare(strict_types=1);


namespace Viabo\security\code\domain\services;


use Viabo\security\code\domain\Code;
use Viabo\security\code\domain\CodeRepository;
use Viabo\security\code\domain\exceptions\WrongCode;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CodeFinder
{
    public function __construct(private CodeRepository $repository)
    {
    }

    public function __invoke(string $userId , string $code): Code
    {
        $filters = Filters::fromValues([
            ['field' => 'userId' , 'operator' => '=' , 'value' => $userId] ,
            ['field' => 'value.value' , 'operator' => '=' , 'value' => $code]
        ]);
        $code = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($code)) {
            throw new WrongCode();
        }

        return $code;
    }
}