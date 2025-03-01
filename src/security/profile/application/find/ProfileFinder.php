<?php declare(strict_types=1);


namespace Viabo\security\profile\application\find;


use Viabo\security\profile\domain\exceptions\ProfileNotExist;
use Viabo\security\profile\domain\ProfileRepository;

final readonly class ProfileFinder
{
    public function __construct(private ProfileRepository $repository)
    {
    }

    public function __invoke(string $profileId): ProfileResponse
    {
        $profile = $this->repository->search($profileId);

        if(empty($profile)){
            throw new ProfileNotExist();
        }

        return new ProfileResponse($profile->toArray());
    }
}