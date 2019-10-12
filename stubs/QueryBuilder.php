<?php

namespace Doctrine\ORM;

/**
 * @template WhereExpr as \Doctrine\ORM\Query\Expr\Base|list<\Doctrine\ORM\Query\Expr\Base|string>|string
 */
class QueryBuilder
{
    /**
     * @param list<string>|string|null $select
     * @param string ...$selects
     */
    public function select($select = null, ...$selects): self {}

    /**
     * @param list<string>|string|null $select
     * @param string ...$selects
     */
    public function addSelect($select = null, ...$selects): self {}

    /**
     * @param WhereExpr $predicate
     * @param WhereExpr ...$predicates
     */
    public function where($predicate = null, ...$predicates): self {}

    /**
     * @param WhereExpr $predicate
     * @param WhereExpr ...$predicates
     */
    public function andWhere($predicate = null, ...$predicates): self {}

    /**
     * @param WhereExpr $predicate
     * @param WhereExpr ...$predicates
     */
    public function orWhere($predicate = null, ...$predicates): self {}

    /**
     * @param WhereExpr $predicate
     * @param WhereExpr ...$predicates
     */
    public function having($predicate = null, ...$predicates): self {}

    /**
     * @param WhereExpr $predicate
     * @param WhereExpr ...$predicates
     */
    public function andHaving($predicate = null, ...$predicates): self {}

    /**
     * @param WhereExpr $predicate
     * @param WhereExpr ...$predicates
     */
    public function orHaving($predicate = null, ...$predicates): self {}
}
