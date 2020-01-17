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
     */
    public function select($select = null, ...$selects): self
    {
    }

    /**
     * @param _SelectExpr|_SelectExpr[]|null $select
     * @param _SelectExpr                    ...$selects
     */
    public function addSelect($select = null, ...$selects): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     */
    public function where($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     */
    public function andWhere($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     */
    public function orWhere($predicate, ...$predicates): self
    {
    }

    /**
     * @param _GroupExpr|_GroupExpr[] $predicate
     * @param _GroupExpr              ...$predicates
     */
    public function groupBy($predicate, ...$predicates): self
    {
    }

    /**
     * @param _GroupExpr|_GroupExpr[] $predicate
     * @param _GroupExpr              ...$predicates
     */
    public function addGroupBy($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     */
    public function having($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     */
    public function andHaving($predicate, ...$predicates): self
    {
    }

    /**
     * @param _WhereExpr $predicate
     * @param _WhereExpr ...$predicates
     */
    public function orHaving($predicate, ...$predicates): self
    {
    }
}
