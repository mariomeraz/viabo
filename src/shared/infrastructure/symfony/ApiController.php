<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\symfony;


use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Viabo\shared\domain\bus\command\Command;
use Viabo\shared\domain\bus\command\CommandBus;
use Viabo\shared\domain\bus\query\Query;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\shared\domain\bus\query\Response;

abstract readonly class ApiController
{
    public function __construct(
        private QueryBus            $queryBus ,
        private CommandBus          $commandBus ,
        private JWTEncoderInterface $JWTEncoder
    )
    {
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function decode(string $token): array
    {
        $message = 'Sin acceso DECODE JWT DECODE' . $token;
        $msg = "TOKEN VACIO" . $token;
        try {
            if (empty($token)) {
                throw new \DomainException($msg , 401);
            }
            $token = explode(' ' , $token);
            return $this->JWTEncoder->decode($token[1]);
        } catch (JWTDecodeFailureException) {
            throw new \DomainException($message , 401);
        }
    }

    protected function encode(array $data): string
    {
        try {
            return $this->JWTEncoder->encode($data);
        } catch (JWTEncodeFailureException) {
            throw new \DomainException('Sin acceso' , 401);
        }
    }

    protected function opensslDecrypt(array $requestData): array
    {
        try {
            $ciphertext = base64_decode($requestData['ciphertext']);
            $initializationVector = base64_decode($requestData['iv']);
            $plaintext = openssl_decrypt(
                $ciphertext , 'AES-256-CBC' , $_ENV['APP_OPENSSL'] , OPENSSL_RAW_DATA , $initializationVector
            );
            return !$plaintext ? throw new \DomainException() : json_decode($plaintext , true);
        } catch (\DomainException) {
            throw new \DomainException('Error de cifrado' , 406);
        }

    }

    protected function opensslEncrypt(array $data): array
    {
        $json = json_encode($data);
        $initializationVector = openssl_random_pseudo_bytes(16);
        $ciphertext = openssl_encrypt(
            $json , 'AES-256-CBC' , $_ENV['APP_OPENSSL'] , OPENSSL_RAW_DATA , $initializationVector
        );
        return ['ciphertext' => base64_encode($ciphertext) , 'iv' => base64_encode($initializationVector)];
    }

    protected function formatResponse(mixed $data , bool $success = true , int $code = 200): array
    {
        return [
            'success' => $success ,
            'code' => $code ,
            'data' => $success ? $data : null ,
            'errorMessage' => !$success ? $data : null
        ];
    }

    protected function generateUuid(): string
    {
        return RamseyUuid::uuid4()->toString();
    }
}