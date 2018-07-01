<?php
namespace Weirdan\PsalmDoctrineCollections;
use Psalm\PluginFacade;

class Plugin
{
    public function __invoke(PluginFacade $psalm): void
    {
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/DoctrineCollections.php');
    }
}
