<?php declare(strict_types=1);


namespace Viabo\backoffice\crypt\application\find;


use Viabo\shared\domain\utils\Crypt;

final class CryptFinder
{
    public function __invoke(string $value , bool $encrypt): CryptResponse
    {
        if($encrypt){
            $value = Crypt::encrypt($value);
        }else{
            $value = Crypt::decrypt($value);
        }
        return new CryptResponse($value);
    }
}