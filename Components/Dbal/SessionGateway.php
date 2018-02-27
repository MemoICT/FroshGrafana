<?php

namespace FroshGrafana\Components\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class SessionGateway
 */
class SessionGateway
{
    /** @var Connection */
    private $connection;

    /**
     * SessionGateway constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     * @param float $interval
     *
     * @return array
     */
    public function getVisitorsCount(\DateTime $fromDate, \DateTime $toDate, float $interval): array
    {
        $query = $this->getCurrentUsersRangeQuery($fromDate, $toDate, $interval);
        $result = $query->select('COUNT(id)', 'modified * 1000')
            ->execute()
            ->fetchAll();

        if (!$result) {
            return [];
        }

        foreach ($result as &$item) {
            $item = \array_values(\array_map('\floatval', $item));
        }

        return $result;
    }

    /**
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     * @param float $interval
     * @return QueryBuilder
     */
    private function getCurrentUsersRangeQuery(\DateTime $fromDate, \DateTime $toDate, float $interval): QueryBuilder
    {
        $query = $this->connection->createQueryBuilder();

        return $query->from('s_core_sessions')
            ->where(
                $query->expr()->andX(
                    $query->expr()->gte('FROM_UNIXTIME(modified)', ':fromDate'),
                    $query->expr()->lte('FROM_UNIXTIME(modified)', ':toDate')
                )
            )->groupBy('modified DIV :interval')
            ->setParameters(
                [
                    'fromDate' => $fromDate->format('Y-m-d H:i:s'),
                    'toDate'   => $toDate->format('Y-m-d H:i:s'),
                    'interval' => $interval,
                ]
            );
    }
}