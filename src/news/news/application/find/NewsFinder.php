<?php declare(strict_types=1);


namespace Viabo\news\news\application\find;


use Viabo\news\news\domain\NewsRepository;

final readonly class NewsFinder
{
    public function __construct(private NewsRepository $repository)
    {
    }

    public function __invoke(): NewsResponse
    {
        $news = $this->repository->searchActives();
        return new NewsResponse($news);
    }
}