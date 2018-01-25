<?php

namespace SwagGrafana\Components\Dbal;

use Doctrine\DBAL\Driver\Connection;

/**
 * Class StatisticsGateway
 */
class StatisticsGateway
{
    /** @var Connection */
    private $connection;

    /**
     * StatisticsGateway constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}