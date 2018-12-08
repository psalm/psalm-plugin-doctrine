<?php
namespace Doctrine\ORM;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Collections\Selectable;

/** @template T */
class EntityRepository implements ObjectRepository, Selectable
{
    /** @var string */
    protected $_entityName;

    /** @var EntityManagerInterface */
    protected $_em;

    /** @var Mapping\ClassMetadata */
    protected $_class;

    /** @param Mapping\ClassMetadata<T> $class */
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class) {}

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
