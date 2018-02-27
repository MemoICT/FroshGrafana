<?php

namespace FroshGrafana\Components\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class OrdersGateway
 */
class OrdersGateway
{
    /** @var Connection */
    private $connection;

    /**
     * OrdersGateway constructor.
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
    public function getOrdersCount(\DateTime $fromDate, \DateTime $toDate, float $interval): array
    {
        $query = $this->getOrdersRangeQuery($fromDate, $toDate, $interval);

        $result = $query->select('COUNT(id)', 'UNIX_TIMESTAMP(ordertime) * 1000')->execute()->fetchAll();

        if (!$result) {
            return [];
        }

        foreach ($result as &$item) {
            $item = \array_values(\array_map('\intval', $item));
        }

        return $result;
    }

    /**
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     * @param float $interval
     *
     * @return array
     */
    public function getTurnover(\DateTime $fromDate, \DateTime $toDate, float $interval): array
    {
        $query = $this->getOrdersRangeQuery($fromDate, $toDate, $interval);

        $result = $query->select(
            [
                'SUM(invoice_amount)',
                'UNIX_TIMESTAMP(ordertime) * 1000',
            ]
        )
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
    private function getOrdersRangeQuery(\DateTime $fromDate, \DateTime $toDate, float $interval): QueryBuilder
    {
        $query = $this->connection->createQueryBuilder();

        return $query->from('s_order')
            ->where(
                $query->expr()->andX(
                    $query->expr()->gte('ordertime', ':fromDate'),
                    $query->expr()->lte('ordertime', ':toDate')
                )
            )->groupBy('UNIX_TIMESTAMP(ordertime) DIV :interval')
            ->setParameters(
                [
                    'fromDate' => $fromDate->format('Y-m-d H:i:s'),
                    'toDate'   => $toDate->format('Y-m-d H:i:s'),
                    'interval' => $interval,
                ]
            );
    }
}