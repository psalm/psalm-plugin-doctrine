<?php

declare(strict_types=1);

namespace Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use Psalm\Plugin\EventHandler\Event\MethodReturnTypeProviderEvent;
use Psalm\Plugin\EventHandler\MethodReturnTypeProviderInterface;
use Psalm\Type;

use function count;
use function current;
use function is_string;

class CollectionFirstAndLast implements MethodReturnTypeProviderInterface
{
    /**
     * @return array<string>
     */
    public static function getClassLikeNames(): array
    {
        return ['Doctrine\Common\Collections\Collection'];
    }

    public static function getMethodReturnType(MethodReturnTypeProviderEvent $event): ?Type\Union
    {
        if (
            $event->getMethodNameLowercase() !== 'first'
            && $event->getMethodNameLowercase() !== 'last'
        ) {
            return null;
        }

        $stmt = $event->getStmt();
        if (! $stmt instanceof MethodCall) {
            return null;
        }

        if (! $stmt->var instanceof Variable) {
            return null;
        }

        if (! is_string($stmt->var->name)) {
            return null;
        }

        $scopedVarName = '$' . $stmt->var->name . '->isempty()';
        if (! isset($event->getContext()->vars_in_scope[$scopedVarName])) {
            return null;
        }

        $type = $event->getContext()->vars_in_scope[$scopedVarName];

        if ($type->isFalse()) {
            $collectionType = $event->getSource()->getNodeTypeProvider()->getType($stmt->var);
            if ($collectionType === null) {
                return null;
            }

            $atomicTypes = $collectionType->getAtomicTypes();
            if (count($atomicTypes) !== 1) {
                return null;
            }

            $type = current($atomicTypes);
            if (! $type instanceof Type\Atomic\TGenericObject) {
                return null;
            }

            $childNode = $type->getChildNodes();
            if (! isset($childNode[1]) || ! $childNode[1] instanceof Type\Union) {
                return null;
            }

            return $childNode[1];
        }

        if ($type->isTrue()) {
            return Type::getFalse();
        }

        return null;
    }
}
