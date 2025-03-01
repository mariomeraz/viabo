<?php declare(strict_types=1);


namespace Viabo\stp\movement\application\find;


use Viabo\stp\shared\domain\stp\StpRepository;

final readonly class MovementsFinder
{
    public function __construct(private StpRepository $stpRepository)
    {
    }

    public function __invoke(array $stpAccount): MovementResponse
    {
        $movements = $this->stpRepository->speiOut($stpAccount);
        return new MovementResponse(array_map(function (array $movement) {
            return [
                'idEF' => $movement['idEF'] ,
                'conceptoPago' => $movement['conceptoPago'] ,
                'cuentaBeneficiario' => $movement['cuentaBeneficiario'] ,
                'nombreBeneficiario' => $movement['nombreBeneficiario'] ,
                'monto' => $movement['monto'] ,
                'tsCaptura' => $movement['tsCaptura'] ,
                'estado' => $movement['estado'] ,
            ];
        } , $movements));
    }
}