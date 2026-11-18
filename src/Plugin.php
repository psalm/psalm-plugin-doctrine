<?php

namespace Weirdan\DoctrinePsalmPlugin;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use OutOfBoundsException;
use Override;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;
use Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider\CollectionFirstAndLast;

use function array_merge;
use function class_exists;
use function glob;

/** @psalm-api */
class Plugin implements PluginEntryPointInterface
{
    /**
     * The stubs of the versions of a package they describe, loaded when that version is installed: directory of
     * stubs => [package, version constraint]
     */
    private const VERSIONED_STUBS = [
        'DBAL/before-4' => ['doctrine/dbal', '<4.0'],
        'DBAL/4' => ['doctrine/dbal', '>=4.0'],
        'ORM/before-3' => ['doctrine/orm', '<3.0'],
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

        foreach (self::VERSIONED_STUBS as $directory => [$package, $constraint]) {
            if (self::isInstalled($package, $constraint)) {
                $files = array_merge($files, glob(__DIR__ . '/../stubs/' . $directory . '/*.phpstub') ?: []);
            }
        }

        return $files;
    }

    /**
     * Whether a version of $package satisfying $constraint is installed. Without Composer's metadata, the newest
     * version is assumed.
     */
    private static function isInstalled(string $package, string $constraint): bool
    {
        if (! class_exists(InstalledVersions::class) || ! class_exists(VersionParser::class)) {
            return self::describesNewestVersion($constraint);
        }

        try {
            return InstalledVersions::satisfies(new VersionParser(), $package, $constraint);
        } catch (OutOfBoundsException $e) {
            return self::describesNewestVersion($constraint);
        }
    }

    /** @psalm-pure */
    private static function describesNewestVersion(string $constraint): bool
    {
        return $constraint[0] === '>';
    }
}
