<?php
namespace Weirdan\DoctrinePsalmPlugin;

use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use RuntimeException;
use SimpleXMLElement;

class Plugin implements PluginEntryPointInterface
{
    /** @var ?DoctrineFacade */
    private static $doctrine = null;

    /** @return void */
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null)
    {
        if ($this->loadConfiguration($config)) {
            $this->loadHooks($psalm);
        }

        $stubs = $this->getStubFiles();
        foreach ($stubs as $file) {
            $psalm->addStubFile($file);
        }
    }

    private function loadHooks(RegistrationInterface $psalm): void
    {
        foreach ([
            Hooks\EntityManager\Find::class
        ] as $class) {
            class_exists($class, true);
            $psalm->registerHooksFromClass($class);
        }
    }

    /** @return string[] */
    private function getStubFiles(): array
    {
        return glob(__DIR__ . '/' . '../stubs/*\\.php');
    }

    private function loadConfiguration(?SimpleXMLElement $config): bool
    {
        if (!$config) {
            // TODO: add warning
            return false;
        }
        self::$doctrine = DoctrineFacade::load($config);
        return true;
    }

    public static function doctrine(): DoctrineFacade
    {
        if (null === self::$doctrine) {
            throw new RuntimeException('Doctrine unavailable, this method is not expected to be called');
        }
        return self::$doctrine;
    }
}
