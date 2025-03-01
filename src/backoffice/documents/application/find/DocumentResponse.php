<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class DocumentResponse implements Response
{
    public function __construct(public array $documentData)
    {
    }
}