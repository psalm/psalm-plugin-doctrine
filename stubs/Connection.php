<?php
// phpcs:ignoreFile
namespace Doctrine\DBAL;

use Doctrine\DBAL\Driver\Connection as DriverConnection;

class Connection implements DriverConnection
{
    /**
     * @var int
     * @deprecated Use TransactionIsolationLevel::READ_UNCOMMITTED.
     */
    public const TRANSACTION_READ_UNCOMMITTED = TransactionIsolationLevel::READ_UNCOMMITTED;

    /**
     * @var int
     * @deprecated Use TransactionIsolationLevel::READ_COMMITTED.
     */
    public const TRANSACTION_READ_COMMITTED = TransactionIsolationLevel::READ_COMMITTED;

    /**
     * @var int
     * @deprecated Use TransactionIsolationLevel::REPEATABLE_READ.
     */
    public const TRANSACTION_REPEATABLE_READ = TransactionIsolationLevel::REPEATABLE_READ;

    /**
     * @var int
     * @deprecated Use TransactionIsolationLevel::SERIALIZABLE.
     */
    public const TRANSACTION_SERIALIZABLE = TransactionIsolationLevel::SERIALIZABLE;

    /** @var int */
    public const PARAM_INT_ARRAY = ParameterType::INTEGER + self::ARRAY_PARAM_OFFSET;

    /** @var int */
    public const PARAM_STR_ARRAY = ParameterType::STRING + self::ARRAY_PARAM_OFFSET;

    /** @var int */
    public const ARRAY_PARAM_OFFSET = 100;
}
