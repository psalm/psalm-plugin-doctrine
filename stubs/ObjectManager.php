<?php

namespace Doctrine\Common\Persistence {
    interface ObjectManager
    {
        /**
         * @param class-string $className
         *
         * @return ObjectRepository<T>
         *
         * @template T
         * @template-typeof T $className
         */
        public function getRepository(string $className);

        /**
         * @param class-string $className
         *
         * @return Mapping\ClassMetadata<T>
         *
         * @template T
         * @template-typeof T $className
         */
        public function getClassMetadata(string $className);

        /**
         * @param class-string $className
         *
         * @return ?T
         *
         * @template T
         * @template-typeof T $className
         */
        public function find(string $className, $id);
    }
}
namespace Doctrine\Common\Persistence\Mapping {
    /** @template T */
    interface ClassMetadata
    {
    }
}
