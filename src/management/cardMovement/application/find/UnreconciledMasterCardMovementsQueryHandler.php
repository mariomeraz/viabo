<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UnreconciledMasterCardMovementsQueryHandler implements QueryHandler
{
    public function __construct(private UnreconciledMasterCardMovementsFinder $finder)
    {
    }

    public function __invoke(UnreconciledMasterCardMovementsQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->card,
            $query->anchoringOrderRegisterDate,
            $query->anchoringOrderAmount,
            $query->threshold,
            $query->conciliation,
            $query->cardOperations
        );
    }
}