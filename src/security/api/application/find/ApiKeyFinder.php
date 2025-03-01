<?php declare(strict_types=1);


namespace Viabo\security\api\application\find;


use Viabo\security\api\domain\ApiName;
use Viabo\security\api\domain\ApiRepository;
use Viabo\security\api\domain\ApiKey;
use Viabo\security\api\domain\exceptions\APINotAuthorized;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class ApiKeyFinder
{
    public function __construct(private ApiRepository $repository)
    {
    }

    public function __invoke(ApiName $name , ApiKey $key): void
    {
        $filter = Filters::fromValues([
            ['field' => 'name.value' , 'operator' => '=' , 'value' => $name->value()] ,
            ['field' => 'key.value' , 'operator' => '=' , 'value' => $key->value()] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ]);

        $api = $this->repository->searchCriteria(new Criteria($filter));

        if (empty($api)) {
            throw new APINotAuthorized();
        }
    }
}