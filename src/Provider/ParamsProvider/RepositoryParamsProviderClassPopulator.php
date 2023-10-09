<?php

declare(strict_types=1);

namespace Weirdan\DoctrinePsalmPlugin\Provider\ParamsProvider;

use Doctrine\Persistence\ObjectRepository;
use Psalm\Plugin\EventHandler\AfterCodebasePopulatedInterface;
use Psalm\Plugin\EventHandler\Event\AfterCodebasePopulatedEvent;
use Weirdan\DoctrinePsalmPlugin\Plugin;

class RepositoryParamsProviderClassPopulator implements AfterCodebasePopulatedInterface
{
    public static function afterCodebasePopulated(AfterCodebasePopulatedEvent $event)
    {
        foreach ($event->getCodebase()->classlike_storage_provider->getAll() as $class) {
            if (isset($class->class_implements[strtolower(ObjectRepository::class)])) {
                RepositoryParamsProvider::$classes[] = $class->name;
            }
        }
        assert(Plugin::$registrationInterface !== null);
        if (class_exists(RepositoryParamsProvider::class)) {
            Plugin::$registrationInterface->registerHooksFromClass(RepositoryParamsProvider::class);
        }
    }
}
