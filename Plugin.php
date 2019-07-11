<?php
namespace Weirdan\DoctrinePsalmPlugin;

use OutOfBoundsException;
use PackageVersions\Versions;
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
        try {
            Versions::getVersion('doctrine/doctrine-bundle');
        } catch (OutOfBoundsException $e) {
            return [];
        }

        return glob(__DIR__ . '/' . 'bundle-stubs/*.php');
    }
}
