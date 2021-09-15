<?php

namespace Weirdan\DoctrinePsalmPlugin;

use Composer\Semver\Semver;
use OutOfBoundsException;
use PackageVersions\Versions;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;
use Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider\CollectionFirstAndLast;

use function array_merge;
use function class_exists;
use function explode;
use function glob;
use function strpos;

class Plugin implements PluginEntryPointInterface
{
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null): void
    {
        $stubs = $this->getStubFiles();
        $stubs = array_merge($stubs, $this->getBundleStubs());
        foreach ($stubs as $file) {
            $psalm->addStubFile($file);
        }

        if (class_exists(CollectionFirstAndLast::class)) {
            $psalm->registerHooksFromClass(CollectionFirstAndLast::class);
        }
    }

    /** @return string[] */
    private function getStubFiles(): array
    {
        return array_merge(
            glob(__DIR__ . '/../stubs/*.phpstub') ?: [],
            glob(__DIR__ . '/../stubs/DBAL/*.phpstub') ?: []
        );
    }

    /** @return string[] */
    private function getBundleStubs(): array
    {
        if (! $this->hasPackage('doctrine/doctrine-bundle')) {
            return [];
        }

        return glob(__DIR__ . '/../' . 'bundle-stubs/*.phpstub');
    }

    private function hasPackage(string $packageName): bool
    {
        try {
            $this->getPackageVersion($packageName);
        } catch (OutOfBoundsException $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws OutOfBoundsException
     */
    private function getPackageVersion(string $packageName): string
    {
        if (class_exists(Versions::class)) {
            /**
             * @psalm-suppress RedundantCondition
             * @psalm-suppress RedundantCast
             */
            return (string) Versions::getVersion($packageName);
        }

        throw new OutOfBoundsException();
    }

    private function hasPackageOfVersion(string $packageName, string $constraints): bool
    {
        $packageVersion = $this->getPackageVersion($packageName);
        if (strpos($packageVersion, '@') !== false) {
            [$packageVersion] = explode('@', $packageVersion);
        }

        if (strpos($packageVersion, 'dev-') === 0) {
            $packageVersion = '9999999-dev';
        }

        return Semver::satisfies($packageVersion, $constraints);
    }
}
