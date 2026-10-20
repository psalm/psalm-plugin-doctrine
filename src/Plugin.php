<?php

namespace Weirdan\DoctrinePsalmPlugin;

use Override;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;
use Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider\CollectionFirstAndLast;

use function array_merge;
use function class_exists;
use function glob;

/** @psalm-api */
class Plugin implements PluginEntryPointInterface
{
    #[Override]
    public function __invoke(RegistrationInterface $psalm, ?SimpleXMLElement $config = null): void
    {
        foreach ($this->getStubFiles() as $file) {
            $psalm->addStubFile($file);
        }

        if (class_exists(CollectionFirstAndLast::class)) {
            $psalm->registerHooksFromClass(CollectionFirstAndLast::class);
        }
    }

    /**
     * @return string[]
     *
     * @psalm-suppress RiskyTruthyFalsyComparison
     */
    private function getStubFiles(): array
    {
        return array_merge(
            glob(__DIR__ . '/../stubs/*.phpstub') ?: [],
            glob(__DIR__ . '/../stubs/DBAL/*.phpstub') ?: []
        );
    }
}
