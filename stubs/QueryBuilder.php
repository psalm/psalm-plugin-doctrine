<?php

namespace Doctrine\ORM;

use Doctrine\ORM\Query\Expr;

/**
 * @template WhereExpr as Expr\Base|string
 * @template SelectExpr as Expr\Func|string
 */
class QueryBuilder
{
    /**
     * @param string|null|array<array-key,string|Expr\Base>|Expr\Base $select
     * @param SelectExpr ...$selects
     */
    public function select($select = null, ...$selects): self {}

    /**
     * @param string|null|array<array-key,string|Expr\Base>|Expr\Base $select
     * @param SelectExpr ...$selects
     */
    public function addSelect($select = null, ...$selects): self {}

    /**
     * @param array<array-key,string|Expr\Base>|Expr\Base|string $predicate
     * @param WhereExpr ...$predicates
     */
    public function where($predicate, ...$predicates): self {}

    /**
     * @param array<array-key,string|Expr\Base>|Expr\Base|string $predicate
     * @param WhereExpr ...$predicates
     */
    public function andWhere($predicate, ...$predicates): self {}

    /**
     * @param array<array-key,string|Expr\Base>|Expr\Base|string $predicate
     * @param WhereExpr ...$predicates
     */
    public function orWhere($predicate, ...$predicates): self {}

    /**
     * @param array<array-key,string|Expr\Base>|Expr\Base|string $predicate
     * @param WhereExpr ...$predicates
     */
    public function having($predicate, ...$predicates): self {}

    /**
     * @param array<array-key,string|Expr\Base>|Expr\Base|string $predicate
     * @param WhereExpr ...$predicates
     */
    public function andHaving($predicate, ...$predicates): self {}

    /**
     * @param array<array-key,string|Expr\Base>|Expr\Base|string $predicate
     * @param WhereExpr ...$predicates
     */
    public function orHaving($predicate, ...$predicates): self {}
}
