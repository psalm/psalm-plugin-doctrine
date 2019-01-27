<?php
namespace Doctrine\Common\Persistence {
    interface ObjectManager
    {
        /**
         * @template T
         * @param class-string $className
         * @template-typeof T $className
         * @return ObjectRepository<T>
         */
        public function getRepository(string $className);

        /**
         * @template T
         * @param class-string $className
         * @template-typeof T $className
         * @return Mapping\ClassMetadata<T>
         */
        public function getClassMetadata(string $className);

        /**
         * @template T
         * @param class-string $className
         * @template-typeof T $className
         * @return ?T
         */
        public function find(string $className, $id);
    }
}

namespace Doctrine\Common\Persistence\Mapping {
    /** @template T */
    interface ClassMetadata {}
}
