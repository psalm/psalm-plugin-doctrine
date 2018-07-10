<?php
namespace Weirdan\PsalmDoctrineCollections;
use Psalm\PluginApi;

class Plugin extends PluginApi\PluginEntryPointInterface
{
    public function __invoke(PluginApi\RegistrationInterface $psalm): void
    {
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/DoctrineCollections.php');
    }
}
