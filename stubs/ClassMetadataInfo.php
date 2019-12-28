<?php

namespace Doctrine\ORM\Mapping;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

class ClassMetadataInfo implements ClassMetadata
{
    /** @var array{name: string, schema: string, indexes: array, uniqueConstraints: array} */
    public $table;

    /** @var array{sequenceName: string, allocationSize: int, initialValue: int} */
    public $sequenceGeneratorDefinition;
}
