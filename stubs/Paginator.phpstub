<?php
// phpcs:ignoreFile
namespace Doctrine\ORM\Tools\Pagination;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
/**
 * @template T
 */
class Paginator implements \Countable, \IteratorAggregate
{
    /**
     * @param QueryBuilder|Query $query
     */
    public function __construct($query, bool $fetchJoinCollection = true) {}
    public function count(): int {}
    public function getFetchJoinCollection(): bool {}
    public function getUseOutputWalkers(): ?bool {}
    public function setUseOutputWalkers(?bool $use): void {}
    public function getQuery(): Query {}
    /**
     * @return \Traversable<mixed,T>
     */
    public function getIterator(): \Traversable {}
}
