<?php declare(strict_types=1);


namespace Viabo\news\news\domain;


interface NewsRepository
{
    public function searchActives(): array;
}