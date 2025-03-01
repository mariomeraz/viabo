<?php declare(strict_types=1);

namespace Viabo\Backend\Controller\news\news\find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Viabo\news\news\application\find\NewsQuery;
use Viabo\shared\infrastructure\symfony\ApiController;

final readonly class NewsFinderController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $this->decode($request->headers->get('Authorization'));
            $news = $this->ask(new NewsQuery());

            return new JsonResponse($news->data);
        } catch (\DomainException $exception) {
            return new JsonResponse($exception->getMessage() , $exception->getCode());
        }
    }
}
