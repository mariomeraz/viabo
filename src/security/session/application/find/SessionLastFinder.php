<?php declare(strict_types=1);


namespace Viabo\security\session\application\find;


use Viabo\security\session\domain\Session;
use Viabo\security\session\domain\SessionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\criteria\Order;

final readonly class SessionLastFinder
{
    public function __construct(private SessionRepository $repository)
    {
    }

    public function __invoke(string $userId): SessionResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'userId' , 'operator' => '=' , 'value' => $userId]
        ]);
        $order = Order::fromValues('loginDate.value' , 'desc');
        $sessions = $this->repository->matching(new Criteria($filters , $order , null , 1));

        if(empty($sessions)){
            return new SessionResponse([]);
        }

        return new SessionResponse($sessions[0]->toArray());
    }
}