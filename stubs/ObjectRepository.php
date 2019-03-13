<?php
namespace Doctrine\Common\Persistence;

/** @template T */
interface ObjectRepository {
    /** @return ?T */
    public function find($id);
}
