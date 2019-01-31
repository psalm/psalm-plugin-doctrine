<?php
namespace Doctrine\ORM;

use Doctrine\Common\Persistence\ObjectManager;

interface EntityManagerInterface extends ObjectManager
{
    /**
     * @template T
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @return EntityRepository<T>
     */
    public function getRepository(string $entityName);

    /**
     * @template T
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @param mixed $id
     * @return ?T
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function find(string $entityName, $id, ?int $lockMode = null, ?int $lockVersion = null);

    /**
     * @template T
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @param mixed $id
     * @return T
     */
    public function getReference(string $entityName, $id);
}
