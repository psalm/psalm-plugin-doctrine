<?php

namespace Doctrine\ORM;

use Doctrine\ORM\Query\Expr;

/**
 * @psalm-type _WhereExpr=Expr\Base|Expr\Comparison|Expr\Func|string
 * @psalm-type _SelectExpr=Expr\Func|string
 */
class QueryBuilder
{
    /**
     * @param _SelectExpr|_SelectExpr[]|null $select
     * @param _SelectExpr                    ...$selects
     *
     * @return static
     */
    public function select($select = null, ...$selects): self
    {
    }

    /**
     * @param _SelectExpr|_SelectExpr[]|null $select
     * @param _SelectExpr                    ...$selects
     *
     * @return static
     */
    public function addSelect($select = null, ...$selects): self
    {
    }

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr              ...$predicates
     *
     * @return static
     */
    public function where($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr              ...$predicates
     *
     * @return static
     */
    public function andWhere($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr              ...$predicates
     *
     * @return static
     */
    public function orWhere($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr              ...$predicates
     *
     * @return static
     */
    public function having($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr              ...$predicates
     *
     * @return static
     */
    public function andHaving($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr              ...$predicates
     *
     * @return static
     */
    public function orHaving($predicate, ...$predicates): self
    {
    }
}
