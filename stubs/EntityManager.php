<?php
namespace Doctrine\ORM;

class EntityManager implements EntityManagerInterface
{
    /**
     * @template T
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @return EntityRepository<T>
     */
    public function getRepository(string $entityName) {}

    /**
     * @template T
     * @param class-string $className
     * @template-typeof T $className
     * @return Mapping\ClassMetadata<T>
     */
    public function getClassMetadata(string $className) {}

    /**
     * @template T
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @return ?T
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function find(string $entityName, $id, ?int $lockMode = null, ?int $lockVersion = null) {}

    /**
     * @template T
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @return T
     */
    public function getReference(string $entityName, $id) {}
}
