<?php

declare(strict_types=1);

namespace Weirdan\DoctrinePsalmPlugin\Provider\ReturnTypeProvider;

use Override;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use Psalm\Plugin\EventHandler\AfterMethodCallAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterMethodCallAnalysisEvent;
use Psalm\Plugin\EventHandler\Event\MethodReturnTypeProviderEvent;
use Psalm\Plugin\EventHandler\MethodReturnTypeProviderInterface;
use Psalm\Type;

use function array_reverse;
use function count;
use function current;
use function explode;
use function implode;
use function is_string;
use function strtolower;

final class CollectionFirstAndLast implements MethodReturnTypeProviderInterface, AfterMethodCallAnalysisInterface
{
    /**
     * @return array<string>
     *
     * @psalm-pure
     */
    #[Override]
    public static function getClassLikeNames(): array
    {
        return [
            'Doctrine\Common\Collections\Collection',
            'Doctrine\Common\Collections\ReadableCollection',
        ];
    }

    #[Override]
    public static function getMethodReturnType(MethodReturnTypeProviderEvent $event): ?Type\Union
    {
        $stmt = $event->getStmt();
        if (! $stmt instanceof MethodCall) {
            return null;
        }

        $scopedVarName = self::getIsEmptyVarName($stmt);
        if ($scopedVarName === null) {
            return null;
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

            $childNode = $type->type_params;
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

    /**
     * Runs after Psalm has forgotten the memoized `isEmpty()` of the collection the call mutates
     */
    #[Override]
    public static function afterMethodCallAnalysis(AfterMethodCallAnalysisEvent $event): void
    {
        $expr = $event->getExpr();
        if (! $expr instanceof MethodCall) {
            return;
        }

        [$className, $methodName] = explode('::', $event->getMethodId());
        if (strtolower($className) !== 'doctrine\\common\\collections\\collection') {
            return;
        }

        $scopedVarName = self::getIsEmptyVarName($expr);
        if ($scopedVarName === null) {
            return;
        }

        if ($methodName === 'add') {
            $event->getContext()->vars_in_scope[$scopedVarName] = Type::getFalse();
        } elseif ($methodName === 'remove' || $methodName === 'removeelement') {
            $event->getContext()->remove($scopedVarName);
        }
    }

    /** @psalm-capabilities read-props */
    private static function getIsEmptyVarName(MethodCall $stmt): ?string
    {
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

        $varParts[] = $varStmt->name;

        return '$' . implode('->', array_reverse($varParts)) . '->isempty()';
    }
}
