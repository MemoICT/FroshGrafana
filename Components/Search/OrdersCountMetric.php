<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Dbal\OrdersGateway;

class OrdersCountMetric extends Metric
{
    /** @var OrdersGateway $ordersGateway */
    private $ordersGateway;

    /**
     * OrdersCountMetric constructor.
     * @param OrdersGateway $ordersGateway
     */
    public function __construct(OrdersGateway $ordersGateway)
    {
        $this->ordersGateway = $ordersGateway;
    }

    /**
     * Returns the id of this metric which is used as target in query requests.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'orders_count';
    }

    /**
     * Returns the name of this metric which is shown in the 'find metric' options on the query tab in panels.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Orders Count';
    }

    /**
     * @return array
     */
    public function getDataPoints(): array
    {
        $range = $this->getRequest()->getRange();
        $fromDate = new \DateTime($range['from']);
        $toDate = new \DateTime($range['to']);

        $fromDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));
        $toDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));

        return $this->ordersGateway->getOrdersCount(
            $fromDate,
            $toDate,
            $this->getRequest()->getIntervalSeconds()
        );
    }
}