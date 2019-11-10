<?php

namespace Weirdan\DoctrinePsalmPlugin;

use OutOfBoundsException;
use PackageVersions\Versions;
use Muglug\PackageVersions\Versions as LegacyVersions;
use SimpleXMLElement;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;

class Plugin implements PluginEntryPointInterface
{
    /** @return void */
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null)
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
        return glob(__DIR__ . '/' . 'stubs/*.php');
    }

    /** @return string[] */
    private function getBundleStubs(): array
    {
        if (!$this->hasPackage('doctrine/doctrine-bundle')) {
            return [];
        }

        return glob(__DIR__ . '/' . 'bundle-stubs/*.php');
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

        if (class_exists(LegacyVersions::class)) {
            return (string) LegacyVersions::getVersion($packageName);
        }

        throw new OutOfBoundsException();
    }
}
