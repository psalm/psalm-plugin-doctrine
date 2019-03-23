<?php
namespace Weirdan\DoctrinePsalmPlugin;

use BadMethodCallException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

class DummyDriver implements Driver
{
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        throw new BadMethodCallException();
    }

    public function getDatabasePlatform()
    {
        throw new BadMethodCallException();
    }

    public function getSchemaManager(Connection $conn)
    {
        throw new BadMethodCallException();
    }

    public function getName()
    {
        return 'dummy';
    }

    public function getDatabase(Connection $conn)
    {
        throw new BadMethodCallException();
    }
}
