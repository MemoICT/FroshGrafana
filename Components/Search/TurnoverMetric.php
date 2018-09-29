<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Dbal\OrdersGateway;

class TurnoverMetric extends Metric implements MetricInterface
{
    /** @var OrdersGateway $ordersGateway */
    private $ordersGateway;

    /**
     * TurnoverMetric constructor.
     *
     * @param OrdersGateway $ordersGateway
     */
    public function __construct(OrdersGateway $ordersGateway)
    {
        $this->ordersGateway = $ordersGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return 'orders_turnover';
    }

    /**
     * {@inheritdoc}
     */
    public function getStateSnapshotColumnName(): string
    {
        return 'orders_turnover';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Turnover';
    }

    /**
     * {@inheritdoc}
     */
    public function getDataPoints(): array
    {
        $range = $this->getRequest()->getRange();
        $fromDate = new \DateTime($range['from']);
        $toDate = new \DateTime($range['to']);

        $fromDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));
        $toDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));

        return $this->ordersGateway->getTurnover(
            $fromDate,
            $toDate,
            $this->getRequest()->getIntervalSeconds()
        );
    }
}