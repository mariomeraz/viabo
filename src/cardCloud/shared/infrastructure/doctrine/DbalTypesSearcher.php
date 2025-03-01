<?php declare(strict_types=1);

namespace Viabo\cardCloud\shared\infrastructure\doctrine;


use Viabo\shared\domain\Utils;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;

class DbalTypesSearcher
{
    private const MAPPINGS_PATH = 'infrastructure/doctrine';

    public static function inPath(string $path, string $contextName): array
    {
        $possibleDbalDirectories = self::possibleDbalPaths($path);
        $dbalDirectories = filter(self::isExistingDbalPath(), $possibleDbalDirectories);
        return reduce(self::dbalClassesSearcher($contextName), $dbalDirectories, []);
    }

    private static function modulesInPath(string $path): array
    {
        return filter(
            static function (string $possibleModule) {
                return !in_array($possibleModule, ['.', '..']);
            },
            scandir($path)
        );
    }

    private static function possibleDbalPaths(string $path): array
    {
        return map(
            static function ($unused, string $module) use ($path) {
                $mappingsPath = self::MAPPINGS_PATH;
                return realpath("$path/$module/$mappingsPath");
            },
            array_flip(self::modulesInPath($path))
        );
    }

    private static function isExistingDbalPath(): callable
    {
        return static function (string $path) {
            return !empty($path);
        };
    }

    private static function namespaceFormatter($baseNamespace): callable
    {
        return static function (string $path, string $module) use ($baseNamespace) {
            return "$baseNamespace\\$module\domain";
        };
    }

    private static function dbalClassesSearcher(string $contextName): callable
    {
        return static function (array $totalNamespaces, string $path) use ($contextName) {
            $possibleFiles = scandir($path);
            $files = filter(
                static function ($file) {
                    return Utils::endsWith('Type.php', $file);
                },
                $possibleFiles
            );

            $namespaces = map(
                static function (string $file) use ($path, $contextName) {
                    $fullPath = str_replace('/', '\\',"$path/$file");
                    $splittedPath = explode("\\src\\$contextName\\", $fullPath);
                    $classWithoutPrefix = str_replace(['.php', '/'], ['', '\\'], $splittedPath[1]);

                    return "Viabo\\$contextName\\$classWithoutPrefix";
                },
                $files
            );
            return array_merge($totalNamespaces, $namespaces);
        };
    }
}