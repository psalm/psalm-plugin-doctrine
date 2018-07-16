<?php
namespace Weirdan\PsalmDoctrineCollections;
use Psalm\PluginApi;

class Plugin implements PluginApi\PluginEntryPointInterface
{
    /** @return void */
    public function __invoke(PluginApi\RegistrationInterface $psalm)
    {
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/DoctrineCollections.php');
    }
}
