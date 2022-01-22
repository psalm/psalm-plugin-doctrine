<?php

declare(strict_types=1);

namespace Weirdan\DoctrinePsalmPlugin;

use Composer\InstalledVersions;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\ClassMetadata as ClassMetadataInterface;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use Throwable;

class MetadataProvider
{
    /** @var MappingDriver|false|null */
    private static $mappingDriver = null;

    /** @var array<class-string, ClassMetadata|null> */
    private static $loadedMetadata = [];

    /**
     * @param class-string $class
     */
    public static function get(string $class): ?ClassMetadataInterface
    {
        $mappingDriver = self::getMappingDriver();
        if ($mappingDriver === null) {
            return null;
        }

        if (!array_key_exists($class, self::$loadedMetadata)) {
            try {
                $metadata = new ClassMetadata($class);
                $mappingDriver->loadMetadataForClass($class, $metadata);
                self::$loadedMetadata[$class] = $metadata;
            } catch (Throwable $_) {
                self::$loadedMetadata[$class] = null; // Don't try loading again
            }
        }

        return self::$loadedMetadata[$class];
    }

    private static function getMappingDriver(): ?MappingDriver
    {
        if (!InstalledVersions::isInstalled("doctrine/orm")) {
            return null;
        }

        if (self::$mappingDriver === null) {
            try {
                self::$mappingDriver = new AnnotationDriver(new AnnotationReader());
            } catch (Throwable $_) {
                // Don't keep trying after it fails the first time.
                self::$mappingDriver = false;
            }
        }

        return self::$mappingDriver ?: null;
    }
}
