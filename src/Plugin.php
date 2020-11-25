<?php

namespace Weirdan\DoctrinePsalmPlugin;

use Composer\Semver\Semver;
use OutOfBoundsException;
use PackageVersions\Versions;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;

use function array_merge;
use function array_search;
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
    }

    /** @return string[] */
    private function getStubFiles(): array
    {
        $files = array_merge(
            glob(__DIR__ . '/../stubs/*.phpstub') ?: [],
            glob(__DIR__ . '/../stubs/DBAL/*.phpstub') ?: []
        );

        if ($this->hasPackageOfVersion('doctrine/collections', '>= 1.6.0')) {
            unset($files[array_search(__DIR__ . '/../stubs/ArrayCollection.phpstub', $files, true)]);
        }

        return $files;
    }

    /** @return string[] */
    private function getBundleStubs(): array
    {
        if (! $this->hasPackage('doctrine/doctrine-bundle')) {
            return [];
        }

        if (
            $this->hasPackage('doctrine/persistence')
            && $this->hasPackageOfVersion('doctrine/persistence', '>= 1.3.0')
        ) {
            return glob(__DIR__ . '/../' . 'bundle-stubs/persistence-1.3+/*.phpstub');
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
