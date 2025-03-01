<?php declare(strict_types=1);


namespace Viabo\security\profile\application\find;


use Viabo\security\profile\domain\Profile;
use Viabo\security\profile\domain\ProfileRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class ProfilesFinder
{
    public function __construct(private ProfileRepository $repository)
    {
    }

    public function __invoke(): ProfileResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'id.value' , 'operator' => '<>' , 'value' => '1'] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ]);
        $profiles = $this->repository->searchCriteria(new Criteria($filters));
        return new ProfileResponse(array_map(function (Profile $profile) {
            return $profile->toArray();
        } , $profiles));
    }
}