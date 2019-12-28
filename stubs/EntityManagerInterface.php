<?php

namespace Doctrine\ORM;

use Doctrine\Common\Persistence\ObjectManager;

interface EntityManagerInterface extends ObjectManager
{
    /**
     * @param class-string $entityName
     *
     * @return EntityRepository<T>
     *
     * @template T
     * @template-typeof T $entityName
     */
    public function getRepository(string $entityName);

    /**
     * @param class-string $entityName
     * @param mixed        $id
     *
     * @return ?T
     *
     * @template T
     * @template-typeof T $entityName
     */
    public function find(string $entityName, $id, ?int $lockMode = null, ?int $lockVersion = null);

    /**
     * @param class-string $entityName
     * @param mixed        $id
     *
     * @return T
     *
     * @template T
     * @template-typeof T $entityName
     */
    public function getReference(string $entityName, $id);
}
