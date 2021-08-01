<?php

declare(strict_types=1);

namespace Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider;

use Psalm\Plugin\EventHandler\Event\MethodReturnTypeProviderEvent;
use Psalm\Plugin\EventHandler\MethodReturnTypeProviderInterface;
use Psalm\Type;
use function is_string;

class CollectionFirstAndLast implements MethodReturnTypeProviderInterface
{
    public static function getClassLikeNames() : array
    {
        return ['Collection'];
    }

    public static function getMethodReturnType(MethodReturnTypeProviderEvent $event) : ?Type\Union
    {
        if (
            $event->getMethodNameLowercase() !== 'first'
            || $event->getMethodNameLowercase() !== 'last'
        ) {
            return null;
        }

        $stmt = $event->getStmt();
        if (!$stmt instanceof \PhpParser\Node\Expr\MethodCall) {
            return null;
        }

        if (!$stmt->var instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }

        if (!is_string($stmt->var->name)) {
            return null;
        }

        $scopedVarName = '$' . $stmt->var->name . '->isEmpty()';
        if (!isset($event->getContext()->vars_in_scope[$scopedVarName])) {
            return null;
        }

        $type = $event->getContext()->vars_in_scope[$scopedVarName];

        if ($type->isFalse()) {
            $returnType = $event->getSource()->getNodeTypeProvider()->getType($stmt);
            if (null === $returnType) {
                return null;
            }

            $returnType->removeType('bool');

            return $returnType;
        }

        return Type::getFalse();
    }
}
