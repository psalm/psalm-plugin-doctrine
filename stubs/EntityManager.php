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
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @param mixed $id
     * @return ?T
     */
    public function find(string $entityName, $id, ?int $lockMode = null, ?int $lockVersion = null) {}

    /**
     * @template T
     * @param class-string $entityName
     * @template-typeof T $entityName
     * @param mixed $id
     * @return T
     */
    public function getReference(string $entityName, $id) {}
}
