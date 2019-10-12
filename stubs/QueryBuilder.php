<?php

namespace Doctrine\ORM;

/**
 * @template WhereExpr as \Doctrine\ORM\Query\Expr\Base|string
 * @template WhereArg as \Doctrine\ORM\Query\Expr\Base|list<\Doctrine\ORM\Query\Expr\Base|string>|string
 *
 * @template SelectExpr as \Doctrine\ORM\Query\Expr\Func|string
 * @template SelectArg as \Doctrine\ORM\Query\Expr\Func|list<\Doctrine\ORM\Query\Expr\Func|string>|string|null
 */
class QueryBuilder
{
    /**
     * @param SelectArg $select
     * @param SelectExpr ...$selects
     */
    public function select($select = null, ...$selects): self {}

    /**
     * @param SelectArg $select
     * @param SelectExpr ...$selects
     */
    public function addSelect($select = null, ...$selects): self {}

    /**
     * @param WhereArg $predicate
     * @param WhereExpr ...$predicates
     */
    public function where($predicate = null, ...$predicates): self {}

    /**
     * @param WhereArg $predicate
     * @param WhereExpr ...$predicates
     */
    public function andWhere($predicate = null, ...$predicates): self {}

    /**
     * @param WhereArg $predicate
     * @param WhereExpr ...$predicates
     */
    public function orWhere($predicate = null, ...$predicates): self {}

    /**
     * @param WhereArg $predicate
     * @param WhereExpr ...$predicates
     */
    public function having($predicate = null, ...$predicates): self {}

    /**
     * @param WhereArg $predicate
     * @param WhereExpr ...$predicates
     */
    public function andHaving($predicate = null, ...$predicates): self {}

    /**
     * @param WhereArg $predicate
     * @param WhereExpr ...$predicates
     */
    public function orHaving($predicate = null, ...$predicates): self {}
}
