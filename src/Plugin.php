<?php

namespace Weirdan\DoctrinePsalmPlugin;

use Composer\InstalledVersions;
use OutOfBoundsException;
use Override;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;
use Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider\CollectionFirstAndLast;

use function array_merge;
use function class_exists;
use function glob;
use function strpos;
use function version_compare;

/** @psalm-api */
class Plugin implements PluginEntryPointInterface
{
    /**
     * The stubs of the versions of a package they describe, loaded when that version is installed: directory of
     * stubs => [package, operator of version_compare(), version]
     */
    private const VERSIONED_STUBS = [
        'DBAL/before-3' => ['doctrine/dbal', '<', '3.0'],
        'DBAL/since-3' => ['doctrine/dbal', '>=', '3.0'],
        'DBAL/before-4' => ['doctrine/dbal', '<', '4.0'],
        'DBAL/since-4' => ['doctrine/dbal', '>=', '4.0'],
        'ORM/before-3' => ['doctrine/orm', '<', '3.0'],
    ];

    #[Override]
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null): void
    {
        foreach ($this->getStubFiles() as $file) {
            $psalm->addStubFile($file);
        }

        if (class_exists(CollectionFirstAndLast::class)) {
            $psalm->registerHooksFromClass(CollectionFirstAndLast::class);
        }
    }

    /**
     * @return string[]
     *
     * @psalm-suppress RiskyTruthyFalsyComparison
     */
    private function getStubFiles(): array
    {
        $files = array_merge(
            glob(__DIR__ . '/../stubs/*.phpstub') ?: [],
            glob(__DIR__ . '/../stubs/DBAL/*.phpstub') ?: []
        );

        foreach (self::VERSIONED_STUBS as $directory => [$package, $operator, $version]) {
            if (self::isInstalled($package, $operator, $version)) {
                $files = array_merge($files, glob(__DIR__ . '/../stubs/' . $directory . '/*.phpstub') ?: []);
            }
        }

        return $files;
    }

    /**
     * Whether the installed version of $package compares to $version with $operator. Without Composer's metadata, or
     * for a branch that isn't numbered, the newest version is assumed.
     *
     * @param '<'|'>=' $operator
     */
    private static function isInstalled(string $package, string $operator, string $version): bool
    {
        $installed = null;

        if (class_exists(InstalledVersions::class)) {
            try {
                $installed = InstalledVersions::getVersion($package);
            } catch (OutOfBoundsException $e) {
            }
        }

        // a dev branch is normalized as `dev-name`, a numbered one as `4.7.9999999.9999999-dev`
        if ($installed === null || strpos($installed, 'dev-') === 0) {
            return $operator === '>=';
        }

        return version_compare($installed, $version, $operator);
    }
}
