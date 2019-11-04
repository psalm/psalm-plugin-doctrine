<?php
namespace Doctrine\ORM;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Collections\Selectable;

/**
 * @template T
 * @template-implements Selectable<int,T>
 * @template-implements ObjectRepository<T>
 */
class EntityRepository implements ObjectRepository, Selectable
{

    /**
     * @var string
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $_entityName;

    /**
     * @var EntityManagerInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $_em;

    /**
     * @var Mapping\ClassMetadata
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $_class;

    /** @param Mapping\ClassMetadata<T> $class */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) {}

    /**
     * @param ?int $lockMode
     * @param ?int $lockVersion
     * @return ?T
     */
    public function find($id, $lockMode = null, $lockVersion = null) {}

    /** @return T[] */
    public function findAll() {}
    /**
     * @return T[]
     * @param ?int $limit
     * @param ?int $offset
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null) {}

    /** @return ?T */
    public function findOneBy(array $criteria, ?array $orderBy = null) {}
}
