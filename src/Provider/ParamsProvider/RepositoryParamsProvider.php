<?php

declare(strict_types=1);

namespace Weirdan\DoctrinePsalmPlugin\Provider\ParamsProvider;

use Doctrine\Persistence\ObjectRepository;
use Psalm\Plugin\EventHandler\Event\MethodParamsProviderEvent;
use Psalm\Plugin\EventHandler\MethodParamsProviderInterface;
use Psalm\Storage\FunctionLikeParameter;
use Psalm\Type\Atomic\TBool;
use Psalm\Type\Atomic\TGenericObject;
use Psalm\Type\Atomic\TInt;
use Psalm\Type\Atomic\TIntRange;
use Psalm\Type\Atomic\TKeyedArray;
use Psalm\Type\Atomic\TList;
use Psalm\Type\Atomic\TLiteralString;
use Psalm\Type\Atomic\TMixed;
use Psalm\Type\Atomic\TNamedObject;
use Psalm\Type\Atomic\TString;
use Psalm\Type\Union;
use Weirdan\DoctrinePsalmPlugin\MetadataProvider;

class RepositoryParamsProvider implements MethodParamsProviderInterface
{
    /** @var array<class-string> */
    public static $classes = [];

    /**
     * @return array<string>
     */
    public static function getClassLikeNames(): array
    {
        return self::$classes;
    }

    public static function getMethodParams(MethodParamsProviderEvent $event): ?array
    {
        $statements_source = $event->getStatementsSource();
        if ($statements_source === null) {
            return null;
        }
        $node_type_provider = $statements_source->getNodeTypeProvider();
        $stmt = $event->getStmt(); // Passed this down locally, Psalm would need updated for it to work
        if ($stmt === null) {
            return null;
        }
        $object_type = $node_type_provider->getType($stmt->var);
        if ($object_type === null || !$object_type->isSingle()) {
            return null;
        }
        $object_type = $object_type->getSingleAtomic();
        if ($object_type instanceof TGenericObject) {
            // TODO fix when using multiple parameters with different positions
            $entity_type = $object_type->type_params[0];
        } elseif ($object_type instanceof TNamedObject) {
            // I didn't see a way to do this without using internal methods
            $class_storage = $statements_source->getCodebase()->classlike_storage_provider->get($object_type->value);
            /** @psalm-suppress UndefinedClass */
            $entity_type = $class_storage->template_extended_params[ObjectRepository::class]["T"]
                ?? $class_storage->template_extended_params[\Doctrine\Common\Persistence\ObjectRepository::class]["T"]
                ?? null;
        } else {
            return null;
        }
        if ($entity_type === null || !$entity_type->isSingle()) {
            return null;
        }
        $entity_type = $entity_type->getSingleAtomic();
        if (!$entity_type instanceof TNamedObject) {
            return null;
        }
        /** @var class-string */
        $entity_class = $entity_type->value;

        $entity_metadata = MetadataProvider::get($entity_class);
        if ($entity_metadata === null) {
            return null;
        }
        $properties = $entity_metadata->getFieldNames();
        $properties = array_combine($properties, $properties);
        if (count($properties) === 0) {
            return null;
        }
        $property_types = array_map(function (string $property) use ($entity_metadata) {
            return $entity_metadata->getTypeOfField($property);
        }, $properties);

        switch ($event->getMethodNameLowercase()) {
            case "findby":
                return [
                    new FunctionLikeParameter(
                        "criteria",
                        false,
                        new Union([new TKeyedArray(
                            array_map(function (?string $property_type) {
                                switch ($property_type) {
                                    case "integer":
                                        $type = new TInt();
                                        break;
                                    case "string":
                                    case "text":
                                        $type = new TString();
                                        break;
                                    case "boolean":
                                        $type = new TBool();
                                        break;
                                    // TODO add more cases
                                    default:
                                        $type = new TMixed();
                                        break;
                                }
                                $union = new Union([$type]);
                                $union = new Union([$type, new TList($union)]);
                                $union->possibly_undefined = true;
                                return $union;
                            }, $property_types),
                        )])
                    ),
                    new FunctionLikeParameter(
                        "orderBy",
                        false,
                        new Union([new TKeyedArray(
                            array_map(function (string $_) {
                                $type = new Union([
                                    new TLiteralString("asc"),
                                    new TLiteralString("ASC"),
                                    new TLiteralString("desc"),
                                    new TLiteralString("DESC"),
                                ]);
                                $type->possibly_undefined = true;
                                return $type;
                            }, $properties),
                        )])
                    ),
                    new FunctionLikeParameter(
                        "limit",
                        false,
                        new Union([new TIntRange(0, null)]),
                    ),
                    new FunctionLikeParameter(
                        "offset",
                        false,
                        new Union([new TIntRange(0, null)]),
                    ),
                ];
        }

        return null;
    }
}
