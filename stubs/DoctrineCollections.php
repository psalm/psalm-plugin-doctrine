<?php
namespace Doctrine\Common\Collections;

use Closure;
use Countable;
use IteratorAggregate;
use ArrayAccess;

/**
 * @template TKey
 * @template TValue
 *
 * @template-extends IteratorAggregate<TKey,TValue>
 * @template-extends ArrayAccess<TKey,TValue>
 */
interface Collection extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @param TValue $element
     * @return true
     */
    public function add($element);

    /**
     * @return void
     */
    public function clear();

    /**
     * @param TValue $element
     * @return bool
     */
    public function contains($element);

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param TKey $key
     * @return TValue|null
     */
    public function remove($key);

    /**
     * @param TValue $element
     * @return bool
     */
    public function removeElement($element);

    /**
     * @param TKey $key
     * @return bool
     */
    public function containsKey($key);

    /**
     * @param TKey $key
     * @return TValue|null
     */
    public function get($key);

    /**
     * @return TKey[]
     */
    public function getKeys();

    /**
     * @return TValue[]
     */
    public function getValues();

    /**
     * @param TKey $key
     * @param TValue $value
     * @return void
     */
    public function set($key, $value);

    /**
     * @return array<TKey,TValue>
     */
    public function toArray();

    /**
     * @return TValue|false
     */
    public function first();

    /**
     * @return TValue|false
     */
    public function last();

    /**
     * @return TKey|null
     */
    public function key();

    /**
     * @return TValue|false
     */
    public function current();

    /**
     * @return TValue|false
     */
    public function next();

    /**
     * @param Closure(TValue):bool $p
     * @return bool
     */
    public function exists(Closure $p);

    /**
     * @param Closure(TValue):bool $p
     * @return Collection<TKey,TValue>
     */
    public function filter(Closure $p);

    /**
     * @param Closure(TValue):bool $p
     * @return bool
     */
    public function forAll(Closure $p);

    /**
     * @template T
     * @param Closure(TValue):T $func
     * @return Collection<TKey,T>
     */
    public function map(Closure $func);

    /**
     * @param Closure(TValue):bool $p
     * @return array{0:Collection<TKey,TValue>,1:Collection<TKey,TValue>}
     */
    public function partition(Closure $p);

    /**
     * @param TValue $element
     * @return false|TKey
     */
    public function indexOf($element);

    /**
     * @param TKey $offset
     * @param int|null $length
     * @return array<TKey,TValue>
     */
    public function slice($offset, $length = null);
}
