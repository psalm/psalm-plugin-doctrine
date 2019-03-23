<?php
namespace Weirdan\DoctrinePsalmPlugin;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\StaticReflectionService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use InvalidArgumentException;
use SimpleXMLElement;

class DoctrineFacade
{
    /** @var EntityManager */
    private $em;

    private function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return non-empty-array<int,string>
     * @throws InvalidArgumentException when encountering unreadable config
     */
    private static function loadPaths(SimpleXMLElement $container): array
    {
        if (!isset($container->path) || !$container->path instanceof SimpleXMLElement) {
            throw new InvalidArgumentException('expecting at least one <path> element');
        }

        $paths = [];

        /** @var SimpleXMLElement $path */
        foreach ($container->path as $path) {
            $paths[] = (string) $path;
        }

        if (empty($paths)) {
            throw new InvalidArgumentException('expecting at least one <path> element');
        }

        return $paths;
    }

    /**
     * @throws InvalidArgumentException when encountering unreadable config
     */
    public static function load(SimpleXMLElement $config): self
    {
        if (!isset($config->doctrine) || !$config->doctrine instanceof SimpleXMLElement) {
            throw new InvalidArgumentException('expecting <doctrine> subelement');
        }

        $doctrine = $config->doctrine;

        if (isset($doctrine->annotations) && $doctrine->annotations instanceof SimpleXMLElement) {
            $paths = self::loadPaths($doctrine->annotations);
            $doctrineConfig = Setup::createAnnotationMetadataConfiguration($paths, true);
        } elseif (isset($doctrine->yaml) && $doctrine->yaml instanceof SimpleXMLElement) {
            $paths = self::loadPaths($doctrine->yaml);
            $doctrineConfig = Setup::createYAMLMetadataConfiguration($paths, true);
        } elseif (isset($doctrine->xml) && $doctrine->xml instanceof SimpleXMLElement) {
            $paths = self::loadPaths($doctrine->xml);
            $doctrineConfig = Setup::createXMLMetadataConfiguration($paths, true);
        } else {
            throw new InvalidArgumentException('expecting one of <annotations>, <yaml>, <xml> subelements');
        }

        $em = EntityManager::create(['driverClass' => DummyDriver::class], $doctrineConfig);
        $em->getMetadataFactory()->setReflectionService(new StaticReflectionService());
        return new self($em);
    }

    /** @param class-string $class */
    public function getClassMetadata(string $class): ClassMetadata
    {
        return $this->em->getClassMetadata($class);
    }
}
