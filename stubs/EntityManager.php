<?php

namespace Doctrine\ORM;

class EntityManager implements EntityManagerInterface
{
    /**
     * @param class-string<T> $entityName
     *
     * @return EntityRepository<T>
     *
     * @template T
     */
    public function getRepository(string $entityName)
    {
    }

    /**
     * @param class-string<T> $entityName
     * @param mixed           $id
     *
     * @return ?T
     *
     * @template T
     */
    public function find(string $entityName, $id, ?int $lockMode = null, ?int $lockVersion = null)
    {
    }

    /**
     * @param class-string<T> $entityName
     * @param mixed           $id
     *
     * @return T
     *
     * @template T
     */
    public function getReference(string $entityName, $id)
    {
    }
}
