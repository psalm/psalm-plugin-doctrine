<?php

namespace Doctrine\DBAL\Query;

/**
 * @psalm-type _WhereExpr=Expression\CompositeExpression|string
 * @psalm-type _SelectExpr=string
 * @psalm-type _GroupExpr=string
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
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     *
     * @return static
     */
    public function where($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     *
     * @return static
     */
    public function andWhere($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     *
     * @return static
     */
    public function orWhere($predicate, ...$predicates): self
    {
    }

    /**
     * @param _GroupExpr|_GroupExpr[] $predicate
     * @param _GroupExpr              ...$predicates
     *
     * @return static
     */
    public function groupBy($predicate, ...$predicates): self
    {
    }

    /**
     * @param _GroupExpr|_GroupExpr[] $predicate
     * @param _GroupExpr              ...$predicates
     *
     * @return static
     */
    public function addGroupBy($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     *
     * @return static
     */
    public function having($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     *
     * @return static
     */
    public function andHaving($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     *
     * @return static
     */
    public function orHaving($predicate, ...$predicates): self
    {
    }
}
