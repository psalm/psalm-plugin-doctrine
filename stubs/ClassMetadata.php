<?php

namespace Doctrine\Common\Persistence\Mapping;

interface ClassMetadata
{
    /**
     * @return class-string
     */
    public function getAssociationTargetClass($assocName);
}
