<?php

namespace Doctrine\ORM\Mapping;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

class ClassMetadataInfo implements ClassMetadata
{
    /**
     * @var array{name: string, schema: string, indexes: array, uniqueConstraints: array}
     */
    public $table;
}
