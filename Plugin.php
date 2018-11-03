<?php
namespace Weirdan\PsalmDoctrineCollections;
use Psalm\PluginApi;
use SimpleXMLElement;

class Plugin implements PluginApi\PluginEntryPointInterface
{
    /** @return void */
    public function __invoke(PluginApi\RegistrationInterface $psalm, ?SimpleXMLElement $config = null)
    {
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/DoctrineCollections.php');
    }
}
