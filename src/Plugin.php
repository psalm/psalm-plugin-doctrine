<?php
namespace Weirdan\DoctrinePsalmPlugin;

use Psalm\Config;
use Psalm\IssueBuffer;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use RuntimeException;
use SimpleXMLElement;
use Weirdan\DoctrinePsalmPlugin\Issue\MissingConfig;

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
            $configFile = Config::locateConfigFile(getcwd());
            assert(is_string($configFile));
            IssueBuffer::addIssues([
                [
                    'severity' => Config::REPORT_INFO,
                    'type' => 'MissingConfig',
                    'message' => 'To use extended checks please add Doctrine plugin configuration',

                    'file_name' => basename($configFile),
                    'file_path' => $configFile,

                    'snippet' => '',
                    'snippet_from' => 0,
                    'snippet_to' => 0,

                    'from' => 0,
                    'to' => 0,
                    'line_from' => 1,
                    'line_to' => 1,
                    'column_from' => 1,
                    'column_to' => 1,
                ],
            ]);
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
