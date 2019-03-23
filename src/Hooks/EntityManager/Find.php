<?php
namespace Weirdan\DoctrinePsalmPlugin\Hooks\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\Common\Persistence\Mapping\MappingException as CommonMappingException;
use Psalm\CodeLocation;
use Psalm\Context;
use Psalm\IssueBuffer;
use Psalm\Issue\InvalidArgument;
use Psalm\Plugin\Hook\MethodReturnTypeProviderInterface;
use Psalm\StatementsSource;
use Psalm\Type;
use Psalm\Type\Atomic;
use Weirdan\DoctrinePsalmPlugin\Plugin;

class Find implements MethodReturnTypeProviderInterface
{
    public static function getClassLikeNames(): array
    {
        return [
            EntityManager::class
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getMethodReturnType(
        StatementsSource $source,
        string $fqClasslikeName,
        string $methodNameLc,
        array $callArgs,
        Context $context,
        CodeLocation $codeLocation,
        array $templateTypeParameters = null,
        string $calledFqClasslikeName = null,
        string $calledMethodNameLc = null
    ): ?Type\Union {
        if ('find' !== $methodNameLc) {
            return null;
        }

        if (!isset($callArgs[0])) {
            return null;
        }

        /** @var Type\Union $potentialEntityType */
        $potentialEntityType = $callArgs[0]->value->inferredType;
        $methodId = ($calledFqClasslikeName ?? $fqClasslikeName) . '::' . ($calledMethodNameLc ?? $methodNameLc);
        /** @var Atomic $type */
        foreach ($potentialEntityType->getTypes() as $type) {
            if ($type instanceof Atomic\TLiteralClassString) {
                /** @var class-string */
                $className = $type->value;
                try {
                    Plugin::doctrine()->getClassMetadata($className);
                } catch (CommonMappingException | MappingException $e) {
                    IssueBuffer::accepts(new InvalidArgument(
                        'Argument 1 of ' . $methodId . ' expects entity class, '
                        . 'non-entity ' . $type->getKey() . ' given',
                        new CodeLocation($source, $callArgs[0])
                    ));
                }
            }
        }
        return null;
    }
}
