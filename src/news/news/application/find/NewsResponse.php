<?php declare(strict_types=1);


namespace Viabo\news\news\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class NewsResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}