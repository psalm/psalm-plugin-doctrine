<?php

namespace Doctrine\ORM;

use Doctrine\ORM\Query\Expr;

/**
 * @psalm-type _WhereExpr=Expr\Base|string
 * @psalm-type _SelectExpr=Expr\Func|string
 */
class QueryBuilder
{
    /**
     * @param null|_SelectExpr|_SelectExpr[] $select
     * @param _SelectExpr ...$selects
     */
    public function select($select = null, ...$selects): self {}

    /**
     * @param null|_SelectExpr|_SelectExpr[] $select
     * @param _SelectExpr ...$selects
     */
    public function addSelect($select = null, ...$selects): self {}

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr ...$predicates
     */
    public function where($predicate, ...$predicates): self {}

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr ...$predicates
     */
    public function andWhere($predicate, ...$predicates): self {}

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr ...$predicates
     */
    public function orWhere($predicate, ...$predicates): self {}

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr ...$predicates
     */
    public function having($predicate, ...$predicates): self {}

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr ...$predicates
     */
    public function andHaving($predicate, ...$predicates): self {}

    /**
     * @param _WhereExpr|_WhereExpr[] $predicate
     * @param _WhereExpr ...$predicates
     */
    public function orHaving($predicate, ...$predicates): self {}
}
