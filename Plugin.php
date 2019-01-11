<?php
namespace Weirdan\DoctrinePsalmPlugin;

use SimpleXMLElement;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;

class Plugin implements PluginEntryPointInterface
{
    /** @return void */
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null)
    {
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/Collections.php');
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/EntityManagerInterface.php');
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/EntityRepository.php');
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/ObjectManager.php');
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/Paginator.php');
        $psalm->addStubFile(__DIR__ . '/' . 'stubs/Expr.php');
    }
}
