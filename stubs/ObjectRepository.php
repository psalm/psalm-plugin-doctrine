<?php
namespace Doctrine\Common\Persistence;

/** @template T */
interface ObjectRepository {
    /** @return ?T */
    public function find($id);

    /** @return T[] */
    public function findAll();

    /**
     * @return T[]
     * @param ?int $limit
     * @param ?int $offset
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /** @return ?T */
    public function findOneBy(array $criteria);
}
