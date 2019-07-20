<?php

namespace Weirdan\DoctrinePsalmPlugin;

use OutOfBoundsException;
use PackageVersions\Versions;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;

use function array_merge;
use function class_exists;
use function explode;
use function glob;
use function preg_grep;
use function version_compare;

use const PREG_GREP_INVERT;

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
        $files = glob(__DIR__ . '/../stubs/*.phpstub') ?: [];

        if ($this->hasPackage('doctrine/collections')) {
            [$ver] = explode('@', $this->getPackageVersion('doctrine/collections'));
            if (version_compare($ver, 'v1.6.0', '>=')) {
                $files = preg_grep('/Collections\.phpstub$/', $files, PREG_GREP_INVERT);
            }
        }

        return array_merge($files, glob(__DIR__ . '/../stubs/DBAL/*.phpstub') ?: []);
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
            return (string) Versions::getVersion($packageName);
        }

        throw new OutOfBoundsException();
    }
}
