<?php
namespace Doctrine\ORM;

class ObjectManager
{
    /**
     * @template T
     * @param class-string $className
     * @template-typeof T $className
     * @return ObjectRepository<T>
     */
    public function getRepository(string $className) {}

    /**
     * @template T
     * @param class-string $className
     * @template-typeof T $className
     * @return Mapping\ClassMetadata<T>
     */
    public function getClassMetadata(string $className) {}

    /**
     * @template T
     * @param class-string $className
     * @template-typeof T $className
     * @return ?T
     */
    public function find(string $className, $id) {}
}
