<?php

declare(strict_types=1);

namespace Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use Psalm\Plugin\EventHandler\Event\MethodReturnTypeProviderEvent;
use Psalm\Plugin\EventHandler\MethodReturnTypeProviderInterface;
use Psalm\Type;

use function array_reverse;
use function count;
use function current;
use function implode;
use function is_string;

class CollectionFirstAndLast implements MethodReturnTypeProviderInterface
{
    /**
     * @return array<string>
     */
    public static function getClassLikeNames(): array
    {
        return [
            'Doctrine\Common\Collections\Collection',
            'Doctrine\Common\Collections\ReadableCollection',
        ];
    }

    public static function getMethodReturnType(MethodReturnTypeProviderEvent $event): ?Type\Union
    {
        $stmt = $event->getStmt();
        if (! $stmt instanceof MethodCall) {
            return null;
        }

        // Get variable or property string
        $varStmt  = $stmt->var;
        $varParts = [];
        while ($varStmt instanceof PropertyFetch && $varStmt->name instanceof Identifier) {
            $varParts[] = $varStmt->name->name;
            $varStmt    = $varStmt->var;
        }

        if (! $varStmt instanceof Variable || ! is_string($varStmt->name)) {
            return null;
        }

        $varParts[]    = $varStmt->name;
        $scopedVarName = '$' . implode('->', array_reverse($varParts)) . '->isempty()';

        if ($event->getFqClasslikeName() === 'Doctrine\Common\Collections\Collection') {
            if ($event->getMethodNameLowercase() === 'add') {
                $event->getContext()->vars_in_scope[$scopedVarName] = Type::getFalse();

                return null;
            }

            if ($event->getMethodNameLowercase() === 'remove' || $event->getMethodNameLowercase() === 'removeelement') {
                $event->getContext()->remove($scopedVarName);

                return null;
            }
        }

        if (
            ! isset($event->getContext()->vars_in_scope[$scopedVarName])
            || $event->getMethodNameLowercase() !== 'first'
            && $event->getMethodNameLowercase() !== 'last'
        ) {
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
